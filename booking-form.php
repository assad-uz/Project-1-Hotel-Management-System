<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Management Data Entry</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h2 class="mb-4">Hotel Management Data Entry Form</h2>
  
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="role-tab" data-toggle="tab" href="#role" role="tab">Role</a></li>
    <li class="nav-item"><a class="nav-link" id="user-tab" data-toggle="tab" href="#user" role="tab">User</a></li>
    <li class="nav-item"><a class="nav-link" id="room-tab" data-toggle="tab" href="#room" role="tab">Room</a></li>
    <li class="nav-item"><a class="nav-link" id="booking-tab" data-toggle="tab" href="#booking" role="tab">Booking</a></li>
  </ul>

  <div class="tab-content border p-3" id="myTabContent">
    <!-- Role -->
    <div class="tab-pane fade show active" id="role" role="tabpanel">
      <form action="insert_role.php" method="POST">
        <div class="form-group">
          <label>Role Type</label>
          <input type="text" name="role_type" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">Save Role</button>
      </form>
    </div>

    <!-- User -->
    <div class="tab-pane fade" id="user" role="tabpanel">
      <form action="insert_user.php" method="POST">
        <div class="form-group">
          <label>Role ID</label>
          <input type="number" name="role_id" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">Save User</button>
      </form>
    </div>

    <!-- Room -->
    <div class="tab-pane fade" id="room" role="tabpanel">
      <form action="insert_room.php" method="POST">
        <div class="form-group">
          <label>Service ID</label>
          <input type="number" name="service_id" class="form-control">
        </div>
        <div class="form-group">
          <label>Room Type ID</label>
          <input type="number" name="room_type_id" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Room ID</label>
          <input type="text" name="room_id" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Room Number</label>
          <input type="text" name="room_number" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Room Price</label>
          <input type="number" step="0.01" name="room_price" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Room Status</label>
          <input type="text" name="room_status" class="form-control">
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Save Room</button>
      </form>
    </div>

    <!-- Booking -->
    <div class="tab-pane fade" id="booking" role="tabpanel">
      <form action="insert_booking.php" method="POST">
        <div class="form-group">
          <label>User ID</label>
          <input type="number" name="user_id" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Room ID</label>
          <input type="number" name="room_id" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Booking Date</label>
          <input type="datetime-local" name="booking_date" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Check-in Date</label>
          <input type="date" name="checkin_date" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Check-out Date</label>
          <input type="date" name="checkout_date" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Payment Status</label>
          <input type="text" name="payment_status" class="form-control">
        </div>
        <div class="form-group">
          <label>Amount</label>
          <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">Save Booking</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
