<!DOCTYPE html>
<html>
<head>
    <title>Report Employee</title>
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
    <h1>Employee List</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">ID</th>
                <th style="width: 12%;">Name</th>
                <th style="width: 10%;">Email</th>
                <th style="width: 10%;">NRIC</th>
                <th style="width: 12%;">Designation</th>
                <th style="width: 12%;">Department</th>
                <th style="width: 10%;">Mobile Phone</th>
                <th style="width: 10%;">Office Phone</th>
                <th style="width: 10%;">Marital Status</th>
                <th style="width: 10%;">Start Date</th>
                <th style="width: 10%;">End Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                     <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->nric }}</td>
                    <td>{{ $user->designation->name ?? '-' }}</td>
                    <td>{{ $user->department->name ?? '-' }}</td>
                    <td>{{ $user->mobile_phone }}</td>
                    <td>{{ $user->office_phone }}</td>
                    <td>{{ $user->martial_status }}</td>
                    <td>{{ $user->start_date }}</td>
                    <td>{{ $user->end_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
