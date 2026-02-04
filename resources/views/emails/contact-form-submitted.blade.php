<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo formulario recibido</title>
</head>
<body style="margin:0;padding:0;background:#ffffff;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#ffffff;padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                
                {{-- HEADER --}}
                <tr>
                    <td style="background:#1057C1;padding:20px;text-align:center;">
                        <img src="{{ asset('assets/img/logoclevertrading-web.png') }}"
                             alt="Clever Trading"
                             style="max-width:180px;">
                    </td>
                </tr>

                {{-- CONTENT --}}
                <tr>
                    <td style="padding:30px;color:#1f2937;">

                        <h2 style="margin-top:0;color:#1057C1;">
                            Nuevo formulario recibido
                        </h2>

                        <p>Se ha recibido un nuevo contacto desde la web:</p>

                        <table width="100%" cellpadding="6" cellspacing="0" style="margin-top:20px;">
                            <tr>
                                <td><strong>Nombre:</strong></td>
                                <td>{{ $customer->first_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Apellidos:</strong></td>
                                <td>{{ $customer->last_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Teléfono:</strong></td>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>País:</strong></td>
                                <td>{{ $customer->country }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ciudad:</strong></td>
                                <td>{{ $customer->city }}</td>
                            </tr>
                            <tr>
                                <td><strong>Empresa:</strong></td>
                                <td>{{ $customer->company }}</td>
                            </tr>
                            <tr>
                                <td><strong>Notas:</strong></td>
                                <td>{{ $customer->notes }}</td>
                            </tr>
                        </table>

                        {{-- INTERESES --}}
                        <h3 style="margin-top:30px;color:#9CCC65;">
                            Intereses seleccionados
                        </h3>

                        @if($customer->categories->isNotEmpty())
                            <ul>
                                @foreach($customer->categories as $category)
                                    <li>{{ $category->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p><em>No se seleccionaron intereses.</em></p>
                        @endif

                        <p style="margin-top:30px;font-size:13px;color:#6b7280;">
                            Fecha de registro: {{ $customer->created_at->format('d/m/Y H:i') }}
                        </p>

                    </td>
                </tr>

                {{-- FOOTER --}}
                <tr>
                    <td style="background:#f9fafb;padding:15px;text-align:center;font-size:12px;color:#6b7280;">
                        Este email se generó automáticamente desde el formulario web de Clever Trading.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
