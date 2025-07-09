<!DOCTYPE html>
<html>

    <head>
        <title>PDF Report</title>
        <style type="text/css">
            @page {
                margin: 1cm;
            }

            body {
                font-family: sans-serif;
                /* margin: 0.5cm 0; */
                text-align: justify;
            }

            .header,
            .footer {
                position: fixed;
                left: 0;
                right: 0;
                color: #aaa;
                font-size: 0.9em;
            }

            .header {
                top: 0;
                border-bottom: 0.1pt solid #aaa;
                margin-bottom: 1cm;
            }

            .footer {
                bottom: 0;
                border-top: 0.1pt solid #aaa;
            }

            .header table,
            .footer table {
                /* width: 100%; */
                border-collapse: collapse;
                border: none;
                margin-bottom: 0.1cm
            }

            .header td,
            .footer td {
                padding: 0;
                width: 50%;
            }

            .page-number {
                text-align: center;
            }

            .page-number:before {
                content: "Page " counter(page);
            }

            hr {
                page-break-after: always;
                border: 0;
            }

            table {
                width: 100%;
            }

            .card {
                border-radius: 0.5rem;
                /* box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); */
                padding: 0.5rem;
                margin-bottom: 1rem;
                border: 0.1pt solid #aaa;
            }

            .separator {
                margin: 1.5cm;
            }

            .right {
                text-align: right;
            }

            .left {
                text-align: left;
            }

            .center {
                text-align: center;
            }

            .font-small {
                font-size: 0.6em;
            }
        </style>
        {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('css/pdf.css') }}" rel="stylesheet"> --}}
    </head>

    <body>
        <div class="header">
            <table>
                <tr>
                    <td><img src="/public/storage/site_logo.png" style="width: 5rem; height: 5rem;" /></td>
                    <td style="text-align: right;">Picanha Brasil - Dübendorf</td>
                </tr>
            </table>
        </div>
        <p class="separator" />
        {{ $slot }}
        <div class="footer">
            <div class="page-number"></div>
        </div>
    </body>

</html>
