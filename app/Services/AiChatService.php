<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;

class AiChatService
{
    protected $openAi;

    public function __construct()
    {
        $this->openAi = OpenAI::chat();
    }

    /**
     * Genera respuesta de la IA con flujo guiado de categorías y productos.
     */
    public function ask(string $message, array $knowledgeMatches = [], ?string $sessionId = null): string
    {
        $hasContact = $this->messageHasContact($message);

        if ($sessionId) {
            $this->saveContact($message, $sessionId);
        }

        // Flujo guiado: si es selección de categoría o producto
        if ($this->isCategorySelection($message)) {
            return $this->handleCategorySelection($message, $sessionId);
        }

        if ($this->isProductSelection($message)) {
            return $this->handleProductSelection($message, $sessionId);
        }

        // Si el usuario pregunta sobre productos, mostramos categorías primero
        if ($this->isProductQuestion($message)) {
            return $this->listCategories();
        }

        // Respuesta normal basada en knowledge
        $context = "";
        if (!empty($knowledgeMatches)) {
            $context .= "Información de Clever Trading:\n";
            $context .= implode("\n", $knowledgeMatches);
            $context .= "\n\n";
        }

        $systemPrompt = $this->buildSystemPrompt($hasContact);

        try {
            $response = $this->openAi->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $context . "Pregunta: {$message}"]
                ],
            ]);

            return $response['choices'][0]['message']['content'] ?? 'No se pudo generar una respuesta.';

        } catch (\Throwable $e) {
            return 'Error al generar la respuesta: ' . $e->getMessage();
        }
    }

    /**
     * Lista las categorías de productos numeradas
     */
    protected function listCategories(): string
    {
        $categories = $this->getProductCategories();
        $prompt = "Por favor, indica el número de la categoría que te interesa:\n";
        foreach ($categories as $i => $cat) {
            $prompt .= ($i + 1) . ". $cat\n";
        }
        return $prompt;
    }

    /**
     * Maneja la selección de categoría
     */
    protected function handleCategorySelection(string $message, ?string $sessionId): string
    {
        $categories = $this->getProductCategories();
        $index = ((int) $message) - 1;

        if (!isset($categories[$index])) {
            return "Número de categoría inválido. Por favor selecciona un número válido.";
        }

        $category = $categories[$index];

        if ($sessionId) {
            $this->saveInterest($sessionId, $category);
        }

        $products = $this->getProductsByCategory($category);
        if (empty($products)) {
            return "No hay productos disponibles en esta categoría en este momento.";
        }

        $reply = "Has seleccionado la categoría: $category\nProductos disponibles:\n";
        foreach ($products as $i => $p) {
            $reply .= ($i + 1) . ". {$p['title']}: {$p['description']}\n";
        }
        $reply .= "\nPor favor, indica el número del producto que te interesa para más detalles o deja tus datos de contacto.";
        return $reply;
    }

    /**
     * Maneja la selección de producto
     */
    protected function handleProductSelection(string $message, ?string $sessionId): string
    {
        $productNumber = (int) $message;
        $allProducts = $this->getAllProductsFlat();
        if (!isset($allProducts[$productNumber - 1])) {
            return "Número de producto inválido. Por favor selecciona un número válido.";
        }

        $product = $allProducts[$productNumber - 1];
        if ($sessionId) {
            $this->saveInterest($sessionId, $product['title']);
        }

        return "Has seleccionado el producto: {$product['title']}\n{$product['description']}\nPara información sobre stock o precios, puedes contactarnos al número de la empresa o dejarnos tu correo y/o teléfono.";
    }

    /**
     * Devuelve todos los productos como array asociativo
     */
    protected function getAllProductsFlat(): array
    {
        return DB::table('products')
            ->select('name as title', 'description')
            ->get()
            ->map(fn($p) => ['title' => $p->title, 'description' => $p->description])
            ->toArray();
    }

    /**
     * Devuelve productos de una categoría como array asociativo
     */
    protected function getProductsByCategory(string $categoryName): array
    {
        $category = DB::table('categories')->where('name', $categoryName)->first();
        if (!$category) return [];

        return DB::table('products')
            ->where('category_id', $category->id)
            ->select('name as title', 'description')
            ->get()
            ->map(fn($p) => ['title' => $p->title, 'description' => $p->description])
            ->toArray();
    }

    /**
     * Devuelve categorías
     */
    protected function getProductCategories(): array
    {
        return DB::table('categories')->pluck('name')->toArray();
    }

    /**
     * Guarda interés en la tabla
     */
    protected function saveInterest(string $sessionId, string $interest): void
    {
        DB::table('chat_user_interests')->updateOrInsert([
            'session_id' => $sessionId,
            'interest' => $interest
        ]);
    }

    protected function isCategorySelection(string $message): bool
    {
        return preg_match('/^\d+$/', trim($message));
    }

    protected function isProductSelection(string $message): bool
    {
        return preg_match('/^\d+$/', trim($message));
    }

    protected function isProductQuestion(string $message): bool
    {
        $keywords = ['producto','productos','catálogo','catalogo','modelo','modelos'];
        $message = mb_strtolower($message);
        foreach ($keywords as $k) {
            if (str_contains($message, $k)) return true;
        }
        return false;
    }

    protected function messageHasContact(string $message): bool
    {
        return preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $message) ||
               preg_match('/\+?[\d\s]{7,20}/', $message);
    }

    protected function saveContact(string $message, string $sessionId): void
    {
        $emails = [];
        $phones = [];

        if (preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $message, $m)) {
            $emails = $m[0];
        }

        if (preg_match_all('/\+?[\d\s]{7,20}/', $message, $m)) {
            foreach ($m[0] as $rawPhone) {
                $phones[] = preg_replace('/\s+/', '', $rawPhone);
            }
        }

        if (!empty($emails) || !empty($phones)) {
            DB::table('chat_user_contacts')->insert([
                'session_id' => $sessionId,
                'email' => $emails[0] ?? null,
                'phone' => $phones[0] ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function getRelevantKnowledge(string $message): array
    {
        $message = mb_strtolower($message);
        $matches = DB::table('knowledge')->get();
        $knowledgeTexts = [];

        foreach ($matches as $match) {
            $text = mb_strtolower(($match->title ?? '') . ' ' . ($match->description ?? '') . ' ' . ($match->additional_info ?? ''));
            foreach (preg_split('/\s+/', $message) as $word) {
                if ($word !== '' && str_contains($text, $word)) {
                    $knowledgeTexts[] = trim(($match->title ?? '') . '. ' . ($match->description ?? '') . ' ' . ($match->additional_info ?? ''));
                    break;
                }
            }
        }

        return array_unique($knowledgeTexts);
    }

    protected function buildSystemPrompt(bool $hasContact): string
    {
        if ($hasContact) {
            return <<<PROMPT
Eres un agente comercial profesional de Clever Trading.
Gracias por proporcionar tus datos de contacto.
Evita saludos repetitivos o frases redundantes.
Finaliza la respuesta de forma educada y profesional, sin volver a pedir información.
PROMPT;
        }

        return <<<PROMPT
Eres un agente comercial profesional de Clever Trading.
Saluda cordialmente al cliente al inicio de la conversación.
Responde de manera natural, como si hablaras con un cliente real.
Usa la información de knowledge y productos para guiar la conversación.
Si el cliente pregunta por precios o stock, sugiere que puede contactarnos al número de la empresa o dejar su correo y/o teléfono.
Invita al cliente a dejar su correo o teléfono solo si es necesario para continuar la conversación o enviar más información.
Evita repetir saludos o frases redundantes.
PROMPT;
    }
}
