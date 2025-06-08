<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <style>
        body {
            font-family: "Helvetica", sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        .container {
            border: 1px solid #555;
            outline: 1px solid #555;
            outline-offset: 4px;
            padding: 10px;
            margin: 10px;
            position: relative;
            height: 980px; 
        }
        .header {
            text-align: center; 
            font-style: italic;
            margin-top: 20px;
            font-size: 20px;
        }
        .section {
            margin-bottom: 10px;
        }
        .signature {
            text-align: center;
            margin-top: 50px;
        }
        .line {
            border-top: 1px solid black;
            width: 60%;
            margin: 10px auto;
        }
        .footer {
            text-align: center; 
            margin-top: 20px;
        }
        .image {
            position: absolute;
            top: 20px;
            left: 60px;
            width: 120px;
            height: auto;
        }
        .content{
            margin-top:100px;
            margin-left:50px;
            margin-right:50px;
        }
        table{
            width: 100%;
        }
        td { 
            vertical-align: top; 
        }
        table .section{
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="image" src="{{ $logo }}" alt="{{$logo}}">
        <div class="header">{{$title}}</div>
        <div class="content">
            <table>
                <tr>
                    <td>
                        <div class="section">Nombre del médico: <strong>{{ $certificateData['$medical_fullName$'] }}</strong></div>
                        <div class="section">Cédula profesional: <strong>{{ $certificateData['$medical_license$'] }}</strong></div>
                        <div class="section">Nombre del paciente: <strong>{{ $certificateData['$patient_first_name$'] }}</strong></div>
                        <div class="section">Apellido del paciente: <strong>{{ $certificateData['$patient_last_name$'] }}</strong></div>
                    </td> 
                    <td class="section">{{date("d/m/Y", strtotime($expires_at))}}</td> 
                </tr> 
            </table> 
            {!!$content!!}
        </div>
        <div class="signature">
            <div class="line"></div>
            {{ $certificateData['$medical_fullName$'] }}<br>
            Cédula profesional: {{ $certificateData['$medical_license$'] }}
        </div> 
    </div>
</body>
</html>
