<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'THSarabun';
            /*font-family: "";*/
            background-color: white;
            color: black;
        }
    </style>

</head>
<body>
<h1>ใบนัดหมาย</h1>
<h1>ชื่อ {{$appointments->patient->user->firstname}} {{$appointments->patient->user->lastname}}</h1>
<h1>เเผนก {{$appointments->doctor->department->departmentName}}</h1>
<h1>หมอ {{$appointments->doctor->user->firstname}} {{$appointments->doctor->user->lastname}}</h1>
<h1>วันที่ {{$appointments->appDate}}</h1>
@if($appointments->appTime == "9:00:00")
    <h1>ช่วงเวลา ช่วงเช้า</h1>
@else
    <h1>ช่วงเวลา ช่วงบ่าย</h1>
@endif
</body>





