<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - IIUM Sport Centre</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style> 
        .admin-grid {
            display: grid;
            grid-template-columns: 1fr 2fr; 
            gap: 20px;
            padding: 20px;
        }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; }
        .status-available { background: #d4edda; color: #155724; }
        .status-maintenance { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body style="background-color: #f4f6f9;">

    <header class="header">
        <div class="logo-section">
            <div class="title-section">
                <h1>IIUM SPORT CENTRE (ADMIN)</h1>
            </div>
        </div>
        <div class="user-section">
            <span>{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin-left: 15px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">(Logout)</button>
            </form>
        </div>
    </header>

    <div class="admin-grid">
        
        <div class="left-column">
            <div class="card">
                <h2>Facility Management</h2>
                <p style="font-size: 0.9rem; color: gray; margin-bottom: 15px;">Set facility availability</p>
                
                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.updateStatus') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Select Facility</label>
                        <select name="facility_id" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 15px;">
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->id }}">
                                    {{ $facility->name }} (Court {{ $facility->court_number }}) - [{{ ucfirst($facility->status) }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Set Status</label>
                        <select name="status" style="width: 100%; padding: 8px; margin-bottom: 15px;">
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Apply Update</button>
                </form>
            </div>
        </div>

        <div class="right-column">
            
            <div class="card">
                <h2>All Bookings</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Facility</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allBookings as $booking)
                            <tr>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->facility->name }} (C{{ $booking->facility->court_number }})</td>
                                <td>{{ $booking->date }}</td>
                                <td>{{ substr($booking->start_time, 0, 5) }}</td>
                                <td>{{ $booking->duration }}H</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h2>Unavailable Facilities</h2>
                @if($unavailableFacilities->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Facility</th>
                            <th>Status</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unavailableFacilities as $facility)
                        <tr>
                            <td>{{ $facility->name }} (Court {{ $facility->court_number }})</td>
                            <td><span class="status-badge status-maintenance">MAINTENANCE</span></td>
                            <td>{{ $facility->updated_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <p style="padding: 10px; color: gray;">All facilities are currently available.</p>
                @endif
            </div>

        </div>
    </div>

</body>
</html>