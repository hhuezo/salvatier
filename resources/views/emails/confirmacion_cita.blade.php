<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación pendiente de cita</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #222;
            line-height: 1.5;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 6px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        strong {
            color: #000;
        }
        .firma {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p><strong>Asunto:</strong> 📅 <strong>Confirmación pendiente de cita agendada</strong></p>

        <p><strong>Cuerpo del correo:</strong></p>

        <p>Estimad@ {{ $cliente ?? '(Nombre del cliente)' }},</p>

        <p>
            Agradecemos el haber <strong>agendado</strong> una cita con nuestro despacho.<br>
            Le informamos que la fecha y hora seleccionadas <strong>se encuentran sujetas a confirmación</strong>, ya que dependen de la
            <strong>disponibilidad de nuestros abogados</strong>.
        </p>

        <p>
            En el transcurso de las próximas horas, uno de nuestros representantes se comunicará con usted para
            <strong>confirmar la cita o proponer una nueva fecha</strong> en caso de ser necesario.
        </p>

        <p>
            Agradecemos su comprensión y quedamos a su disposición para cualquier consulta adicional.
        </p>

        <div class="firma">
            <p>
                Atentamente,<br>
                <strong>SALVATIER ABOGADOS, S.A.S. DE C.V.</strong><br>
                Cel. 7030-7615<br>
                <a href="mailto:contacto@salvatierabogados.com">Correo electrónico</a> |
                <a href="https://salvatierabogados.com" target="_blank">Sitio web</a>
            </p>
        </div>
    </div>
</body>
</html>
