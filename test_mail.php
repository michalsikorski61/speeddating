<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Test maila</title>
        <meta name="description" content="Test maila">
        <meta name="keywords" content="mail">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <![endif]-->


    </head>
    <body>
        <div class="container">
            <header>
                <h1>Test wysyłania e-mail!</h1>
            </header>

            <main>
                <article>
                    <?php
                        $to = 'michalsikorski@gmail.com';
                        $from = 'Ebooki uczące sztuki <msikorski@100ppro.net>';
                        $replyTo = 'Biuro <msikorski@100ppro.net>';
                        $subject = 'Darmowy, świetny ebook - HTML na przykładach';
                        $msg = '<p>Dzień dobry!' ."\r\n\r\n".'Oto link do naszego świetnego ebooka: <a href="https://domena.pl/ebook.pdf">POBIERZ EBOOKA</a></p>';
                        $headers = 'From: ' . $from . "\r\n";
                        $headers .= 'Reply-To: ' . $replyTo . "\r\n";
                        mail($to, $subject,$msg, $headers);
                    ?>
                </article>
            </main>
        </div>
    </body>
</html>