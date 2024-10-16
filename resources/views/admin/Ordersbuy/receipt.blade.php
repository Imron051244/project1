<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จการซื้อขายผลไม้</title>

    <!-- นำเข้า Google Font: Noto Serif Thai -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Serif+Thai:wght@100..900&display=swap');
    </style>

    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        body {
            font-family: 'Noto Serif Thai', serif;
            /* ใช้ฟอนต์ Noto Serif Thai */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }

        .receipt-container {
            width: 100%;
            max-width: 210mm;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
            min-height: 800px;
            /* เพิ่มความสูงขั้นต่ำให้ใบเสร็จ */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            margin: 0;
        }

        .header p {
            font-size: 14px;
            margin: 5px 0;
        }

        .company-info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .order-info {
            margin-bottom: 15px;
        }

        .product-info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f0f0f0;
        }

        .total {
            text-align: right;
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            color: #666;
        }

        /* ปรับตำแหน่งของปุ่มพิมพ์ใบเสร็จให้อยู่ด้านล่างสุดของใบเสร็จ */
        .print-button {
            position: absolute;
            bottom: 20px;
            /* เว้นระยะห่างจากด้านล่าง */
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #218838;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                width: 100%;
                max-width: none;
                border: none;
                padding: 10mm;
            }

            .header h1 {
                font-size: 24px;
            }

            table th,
            table td {
                padding: 12px;
                text-align: left;
                font-size: 16px;
            }

            .total {
                font-size: 22px;
            }

            .footer {
                font-size: 14px;
            }

            /* ซ่อนปุ่มพิมพ์เมื่อพิมพ์ใบเสร็จ */
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
   
    <div class="receipt-container">
        <!-- Header Section -->
        <div class="header">
            <h1>ใบเสร็จการซื้อขายผลไม้</h1>
            <p>หมายเลขใบสั่งซื้อ: {{$getSinglebuy->getuser_buy->id}} </p>
        </div>

        <!-- Company Information -->
        <div class="company-info">
            <p>ร้านผลไม้สด "สหายผลไม้"</p>
            <p>ที่อยู่: </p>
            <p>โทร: 080-705-8890</p>
        </div>

        <!-- Order Information -->
        <div class="order-info">
            <p><strong>ชื่อลูกค้า:</strong> {{$getSinglebuy->getuser_buy->name}} {{$getSinglebuy->getuser_buy->last_name}} </p>
            <p><strong>วันที่สั่งซื้อ:</strong> {{ \Carbon\Carbon::parse($getSinglebuy->getuser_buy->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</p>
           
            <p><strong>เบอร์โทรศัพท์:</strong> {{ substr($getSinglebuy->getuser_buy->phone, 0, 3) }}-{{ substr($getSinglebuy->getuser_buy->phone, 3, 3) }}-{{ substr($getSinglebuy->getuser_buy->phone, 6) }}</p>
        </div>

        <!-- Product Information -->
        <div class="product-info">
            <table>
                <thead>
                    <tr>
                        <th>สินค้า/เกรด</th>
                        <th>ปริมาณ/กีโลกรัม</th>
                        <th>ราคา/กีโลกรัม</th>
                        <th>รวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalAmount = 0; // ตัวแปรสำหรับเก็บยอดรวมทั้งหมด
                    $total_QTY = 0;
                    @endphp
                    @foreach ($getSinglebuy->getbuys_d as $getdetail)
                    <tr>
                        <td>{{$getdetail->getProduct->title}} - {{$getdetail->grade}} </td>
                        <td>{{$getdetail->qty_buy}}</td>
                        <td>฿ {{ number_format($getdetail->price, 2) }} </td>
                        <td>฿ {{ number_format($getdetail->price_total, 2) }}</td>
                    </tr>
 
                    @php
                    // เพิ่มราคาของแต่ละรายการในยอดรวมทั้งหมด
                    $totalAmount += $getdetail->price_total;
                    $total_QTY += $getdetail->qty_buy
                    @endphp
                    @endforeach

                </tbody>
            </table>
        </div>

        <!-- Total Amount -->
        <div class="total">
        <p><strong>ยอดรวมผลไม้:</strong> {{ number_format($total_QTY,2) }} กีโลกรัม </p>
            <p><strong>ยอดรวมที่ต้องจ่าย:</strong> {{ number_format($totalAmount, 2) }} บาท </p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>ขอบคุณที่เลือกซื้อสินค้ากับเรา</p>
        </div>

        <!-- Print Button -->
        <button class="print-button" onclick="printReceipt()">พิมพ์ใบเสร็จ</button>
    </div>
    
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</body>

</html>