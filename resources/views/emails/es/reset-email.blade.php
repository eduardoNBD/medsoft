<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Correo Electrónico</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#334155" style="padding: 40px 0 30px 0;color: #ffffff;font-size: 24px;font-weight: bold;font-family: Arial, sans-serif;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                                <img width="200px" src="{{$logoBase64}}" alt="SVG Image">
                                <h1 style="margin:0;font-size:42px;margin-top:10px;padding: 0px 20px;">Restablecer Contraseña</h1>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #333333; font-family: Arial, sans-serif; font-size: 14px;">  
                                            <p>Hola, {{$userFullName}}</p>
                                            <p>Hemos recibido una solicitud para restablecer tu contraseña. Si no realizaste esta solicitud, puedes ignorar este correo. De lo contrario, haz clic en el botón de abajo para crear una nueva contraseña:</p>
                                            <br>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td align="center">
                                                        <a href="{{$resetLink}}" style="background-color: #334155; color: #ffffff; padding: 12px 24px; text-decoration: none; font-size: 16px; font-weight: bold; border-radius: 5px; display: inline-block;">
                                                            Restablecer Contraseña
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <p>Si no solicitaste restablecer tu contraseña, por favor contáctanos de inmediato.</p>
                                            <br>
                                            <p>{{config('app.name')}}</p>
                                            <br>
                                            <p>Contacto:</p>
                                            <a href="mailto:unidadmedicavph@gmail.com">unidadmedicavph@gmail.com</a> | 52(331) 396-1004
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#334155" style="padding: 30px 30px 30px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" align="center">
                                            <p>&copy; {{ date('Y') }} {{config('app.name')}}.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
