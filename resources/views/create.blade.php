<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Center - Booking</title>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Small fix to make alerts look good */
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 5px; color: white; }
        .alert-success { background-color: #28a745; }
        .alert-danger { background-color: #dc3545; }
        /* Fix for radio buttons looking like the buttons in your design */
        .radio-group label { display: inline-block; margin-right: 10px; cursor: pointer; }
        .radio-group input[type="radio"] { margin-right: 5px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-section">
            <div class="logo"></div>
            <div class="title-section">
                <h1>IIUM SPORT CENTRE</h1>
            </div>
        </div>
        <div class="user-section">
            <div class="user-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <span style="font-weight: 500;">{{ Auth::user()->name ?? 'User' }}</span>
            
            <form method="POST" action="{{ route('logout') }}" style="margin-left: 10px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; cursor:pointer; font-size:0.9rem;">(Logout)</button>
            </form>
        </div>
    </header>

    <div class="main-content">
        
        <div class="card">
            <h2>Booking</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0; padding-left:15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf <div class="form-group">
                    <label>Facility</label>
                    <select name="facility_id" required style="width: 100%; padding: 8px;">
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->id }}">
                                {{ $facility->name }} (Court {{ $facility->court_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <select name="start_time" required>
                            <option value="08:00:00">08:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="12:00:00">12:00 PM</option>
                            <option value="14:00:00">02:00 PM</option>
                            <option value="16:00:00">04:00 PM</option>
                            <option value="18:00:00">06:00 PM</option>
                            <option value="20:00:00">08:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Duration</label>
                    <div class="radio-group">
                        <label><input type="radio" name="duration" value="1" checked> 1 Hour</label>
                        <label><input type="radio" name="duration" value="2"> 2 Hours</label>
                        <label><input type="radio" name="duration" value="3"> 3 Hours</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px;">Add Booking</button>
            </form>
        </div>

        <div class="card">
            <h2>My Booking</h2>
            
            <div class="table-container">
                <table style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #ddd; text-align: left;">
                            <th style="padding: 10px;">Facility</th>
                            <th style="padding: 10px;">Date</th>
                            <th style="padding: 10px;">Time</th>
                            <th style="padding: 10px;">Duration</th>
                            <th style="padding: 10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myBookings as $booking)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">{{ $booking->facility->name }} (C{{ $booking->facility->court_number }})</td>
                            <td style="padding: 10px;">{{ $booking->date }}</td>
                            <td style="padding: 10px;">{{ substr($booking->start_time, 0, 5) }}</td>
                            <td style="padding: 10px;">{{ $booking->duration }}H</td>
                            <td style="padding: 10px;">
                                <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" style="background-color:#ff4444; color:white; padding:5px 10px; border:none; border-radius:4px; cursor:pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: gray;">
                                No bookings found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="action-buttons" style="margin-top: 20px;">
                </div>
        </div>
    </div>
</body>
</html>