<!DOCTYPE html>
<html>
<head>
    <title>Report Leave Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }
        thead {
            background-color: #f2f2f2;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 10px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #fbfbfb;
        }
    </style>
</head>
<body>
    <h1>Report Leave Requests</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">ID</th>
                <th style="width: 12%;">Name</th>
                <th style="width: 10%;">Leave Type</th>
                <th style="width: 10%;">Duration</th>
                <th style="width: 12%;">Start Date</th>
                <th style="width: 12%;">End Date</th>
                <th style="width: 10%;">Reason</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveRequests as $leaveReq)
                <tr>
                     <td>{{ $loop->iteration }}</td>
                    <td>{{ $leaveReq->user->name }}</td>
                    <td>{{ $leaveReq->leaveType->name }}</td>
                    <td>{{ $leaveReq->duration }}</td>
                    <td>{{ $leaveReq->start_date }}</td>
                    <td>{{ $leaveReq->end_date }}</td>
                    <td>{{ $leaveReq->reason }}</td>
                    <td>{{ $leaveReq->status_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
