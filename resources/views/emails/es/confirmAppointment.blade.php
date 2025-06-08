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
                                <h1 style="margin:0;font-size:42px;margin-top:10px;padding: 0px 20px;">Cita confirmada</h1>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #333333; font-family: Arial, sans-serif; font-size: 14px;">  
                                            <p>Hola, {{$userFullName}}</p>
                                            <br>
                                            <p>Nos complace informarte que tu cita ha sido confirmada exitosamente. Aquí tienes los detalles:</p>
                                            <br>
                                            <p><strong>Fecha:</strong> {{$appointment_date}}</p>
                                            <p><strong>Lugar:</strong> {{$appointment_fullAddress}}</p>
                                            <p><strong>Asunto:</strong> {{$subject}}</p>
                                            <br>
                                            <p>Si necesitas realizar algún cambio o tienes alguna duda, no dudes en contactarnos.</p>
                                            <br>
                                            <p>Gracias por confiar en nosotros. ¡Te esperamos!</p>
                                            <br>
                                            <p>Atentamente,</p>
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
