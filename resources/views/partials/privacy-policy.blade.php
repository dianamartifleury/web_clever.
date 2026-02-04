<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Privacy & Cookies Policy') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            <div class="container" style="max-width: 800px;">
                <p><strong>Last updated:</strong> {{ now()->format('F j, Y') }}</p>

                <p>
                    This Privacy & Cookies Policy explains how <strong>Clever Trading</strong> ("we", "our", "us") 
                    collects, uses, and protects your personal data when you use our website.
                </p>

                <h3 class="mt-4 font-semibold">1. Information We Collect</h3>
                <ul class="list-disc pl-6">
                    <li>Technical information (browser type, IP address, device type)</li>
                    <li>Geolocation (if you consent to share it)</li>
                    <li>Language and interaction data (clicks, visited pages)</li>
                    <li>Contact details (if you submit a form)</li>
                </ul>

                <h3 class="mt-4 font-semibold">2. Use of Cookies</h3>
                <p>Cookies are small text files stored on your device when you visit a website. We use cookies to:</p>
                <ul class="list-disc pl-6">
                    <li>Enable website functionality (essential cookies)</li>
                    <li>Analyze website traffic and performance (analytics cookies)</li>
                    <li>Improve user experience and remember preferences</li>
                </ul>

                <p>
                    You can manage your cookie preferences anytime through your browser settings or by adjusting your consent in our cookie banner.
                </p>

                <h3 class="mt-4 font-semibold">3. Google Analytics</h3>
                <p>
                    With your consent, we use Google Analytics to understand user behavior and improve our services.  
                    Data is anonymized where possible. Learn more about Google’s privacy policy 
                    <a href="https://policies.google.com/privacy" target="_blank" class="text-blue-500 underline">here</a>.
                </p>

                <h3 class="mt-4 font-semibold">4. How We Protect Your Data</h3>
                <p>
                    We implement industry-standard security measures to protect your information from unauthorized access, alteration, or destruction.
                </p>

                <h3 class="mt-4 font-semibold">5. Your Rights</h3>
                <p>
                    You may have the right to access, correct, delete, or restrict the use of your personal data.  
                    Contact us at <a href="mailto:support@clevertrading.com" class="text-blue-500 underline">support@clevertrading.com</a>.
                </p>

                <h3 class="mt-4 font-semibold">6. Contact Us</h3>
                <ul class="list-disc pl-6">
                    <li>Email: <a href="mailto:support@clevertrading.com" class="text-blue-500 underline">support@clevertrading.com</a></li>
                    <li>Company: Clever Trading</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
