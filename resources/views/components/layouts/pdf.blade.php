<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
        <title>PDF Report</title>
        <style type="text/css">
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 3cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 1cm;
                right: 1cm;
                height: 3cm;
            }

            header table {
                border-bottom: 0.1pt solid #aaa;
            }

            /** Define the footer rules **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 1cm;
                right: 1cm;
                height: 2cm;
            }

            footer div {
                border-top: 0.1pt solid #aaa;
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

            .table-bordered {
                margin-top: 1rem;
                border-top: 1px dashed #aaa;
                border-bottom: 1px dashed #aaa;
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

            .font-bold {
                font-weight: bold;
            }

            .mt-1 {
                margin-top: 1rem;
            }
        </style>
        {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('css/pdf.css') }}" rel="stylesheet"> --}}
    </head>

    <body>
        <header>
            <table>
                <tr>
                    <td><img src="/public/storage/site_logo.png" style="width: 5rem; height: 5rem;" /></td>
                    <td class="right">Picanha Brasil - Dübendorf</td>
                </tr>
            </table>
        </header>
        {{-- <p class="separator" /> --}}
        <footer>
            <div class="page-number"></div>
        </footer>
        {{ $slot }}
    </body>

</html>
