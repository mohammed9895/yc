<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Muscat SMS Progress</title>
    <meta http-equiv="refresh" content="3">
    <style>
        body{font-family:Arial;padding:20px}
        .box{padding:12px;border:1px solid #ddd;border-radius:10px;margin-bottom:14px}
        table{width:100%;border-collapse:collapse}
        td,th{border-bottom:1px solid #eee;padding:8px;text-align:left}
        .sent{color:green}
        .failed{color:red}
    </style>
</head>
<body>

<h2>Muscat SMS Progress</h2>

<div class="box">
    @if(!$progress)
        <b>No progress found.</b> Start the job first:
        <a href="/admin/muscat-sms/start">Start SMS Job</a>
    @else
        <div><b>Status:</b> {{ $progress['status'] }}</div>
        <div><b>Sent:</b> {{ $progress['sent'] }} | <b>Failed:</b> {{ $progress['failed'] }}</div>
        <div><b>Current phone:</b> {{ $progress['current_phone'] ?? '-' }}</div>
        <div><b>Started:</b> {{ $progress['started_at'] ?? '-' }}</div>
        <div><b>Updated:</b> {{ $progress['updated_at'] ?? '-' }}</div>
    @endif
</div>

@if($progress && !empty($progress['items']))
    <div class="box">
        <h3>Latest numbers</h3>
        <table>
            <thead>
            <tr>
                <th>Time</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach(array_reverse($progress['items']) as $row)
                <tr>
                    <td>{{ $row['at'] }}</td>
                    <td>{{ $row['phone'] }}</td>
                    <td class="{{ $row['status'] === 'sent' ? 'sent' : 'failed' }}">
                        {{ $row['status'] }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <small>Auto refresh every 3 seconds.</small>
    </div>
@endif

</body>
</html>
