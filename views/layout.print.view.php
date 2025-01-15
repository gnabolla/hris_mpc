<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Print Document') ?></title>
    <!-- Print-optimized CSS can go here -->
    <style>
        /* Basic page margins, remove unneeded elements, etc. */
        @media print {

            /* Hide any buttons or elements you don’t want in the final print */
            .no-print {
                display: none !important;
            }

            /* Provide typical page margins */
            body {
                margin: 20mm 15mm;
                font-family: Arial, sans-serif;
                font-size: 14px;
            }
        }

        @media print {

            #sidebar,
            .navbar,
            .footer,
            .someOtherUi,
            button.no-print {
                display: none !important;
            }

            body {
                margin: 20mm;
            }
        }

        @media screen {

            /* Optionally style for on-screen preview */
            body {
                margin: 20px;
            }
        }

        /* Additional styling for your payslip table or fields */
        .payslip-container {
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }

        .payslip-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .field-label {
            font-weight: bold;
        }

        /* etc. */
    </style>
</head>

<body>

    <?php
    // Include the content from whatever view you’re passing in
    require $basePath . '/' . $view;
    ?>

</body>

</html>