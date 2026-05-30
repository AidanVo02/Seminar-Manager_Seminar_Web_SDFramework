{{-- Bản tóm tắt topic để in ra trình duyệt hoặc xuất PDF. --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Topic Summary - {{ $topic->title }}</title>
    <style>
        /* Style tối giản tập trung vào in ấn để bản xuất trông sạch sẽ. */
        body { font-family: Georgia, serif; margin: 32px; color: #1f1a14; }
        h1, h2, h3, p { margin-top: 0; }
        .meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin: 24px 0; }
        .card { border: 1px solid #d8cbb5; border-radius: 16px; padding: 18px; margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border-bottom: 1px solid #ddd; padding: 10px 8px; text-align: left; vertical-align: top; }
        .toolbar { margin-bottom: 20px; display: flex; gap: 12px; }
        .button { display: inline-block; padding: 10px 16px; border-radius: 999px; background: #ba4a1a; color: white; text-decoration: none; }
        .secondary { background: #ede1cf; color: #1f1a14; }
        @media print { .toolbar { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    {{-- Thanh công cụ sẽ ẩn khi in. --}}
    <div class="toolbar">
        <button class="button" onclick="window.print()">In / Lưu PDF</button>
        <a class="button secondary" href="{{ route('topics.show', $topic) }}">Quay lại topic</a>
    </div>

    <h1>{{ $topic->title }}</h1>
    <p>{{ $topic->description }}</p>

    {{-- Các thẻ tóm tắt ở phía trên. --}}
    <div class="meta">
        <div class="card">
            <h3>Giảng viên</h3>
            <p>{{ $topic->lecturer->name }}</p>
            <p>{{ $topic->lecturer->email }}</p>
        </div>
        <div class="card">
            <h3>Tóm tắt</h3>
            <p>Tổng đăng ký: {{ $topic->registrations->count() }}</p>
            <p>Đã duyệt: {{ $topic->registrations->where('status', 'approved')->count() }}</p>
            <p>Đã upload báo cáo: {{ $topic->registrations->filter(fn ($registration) => $registration->submission)->count() }}</p>
        </div>
    </div>

    {{-- Bảng registration là nội dung chính của bản xuất. --}}
    <div class="card">
        <h2>Tóm tắt đăng ký</h2>
        <table>
            <thead>
                <tr>
                    <th>Sinh viên</th>
                    <th>Trạng thái</th>
                    <th>Báo cáo</th>
                    <th>Bảo vệ</th>
                    <th>Điểm</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topic->registrations as $registration)
                    <tr>
                        <td>
                            <strong>{{ $registration->student->name }}</strong><br>
                            {{ $registration->student->email }}
                        </td>
                        <td>{{ ucfirst($registration->status) }}</td>
                        <td>
                            @if ($registration->submission)
                                {{ $registration->submission->original_name }}<br>
                                {{ $registration->submission->submitted_at->format('d/m/Y H:i') }}
                            @else
                                Chưa nộp
                            @endif
                        </td>
                        <td>
                            @if ($registration->presentation)
                                {{ $registration->presentation->scheduled_at->format('d/m/Y H:i') }}<br>
                                {{ $registration->presentation->room }}
                            @else
                                Chưa xếp lịch
                            @endif
                        </td>
                        <td>
                            @if ($registration->score)
                                {{ number_format($registration->score->score, 2) }}/10<br>
                                {{ $registration->score->comment }}
                            @else
                                Chưa chấm điểm
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Không có đăng ký nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
