<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Notification</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#334155" style="padding: 40px 0 30px 0;color: #ffffff;font-size: 24px;font-weight: bold;font-family: Arial, sans-serif;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                                <img width="200px" src="{{$logoBase64}}" alt="SVG Image">
                                <h1 style="margin:0;font-size:42px;margin-top:10px;padding: 0px 20px;">New Document!</h1>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #333333; font-family: Arial, sans-serif; font-size: 14px;">  
                                            <p>Hello, {{$userFullName}}</p>
                                            <br>
                                            <p>We want to confirm that your {{$type}} document has been generated.</p> 
                                            <br>
                                            <p>If you need to make any changes or have any questions, please do not hesitate to contact us.</p>
                                            <br>
                                            <p>Thank you for trusting us. We look forward to seeing you!</p>
                                            <br>
                                            <p>Best regards,</p>
                                            <p>{{config('app.name')}}</p>
                                            <br>
                                            <p>Contact:</p>
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
