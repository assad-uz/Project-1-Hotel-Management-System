CREATE TABLE role (
  id INT PRIMARY KEY AUTO_INCREMENT,
  role_type VARCHAR(50) NOT NULL
);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  role_id INT NOT NULL,
  firstname VARCHAR(100) NOT NULL,
  lastname VARCHAR(100) NOT NULL,
  username VARCHAR(100) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
  FOREIGN KEY (role_id) REFERENCES role (id)
);

CREATE TABLE room_type (
  id INT PRIMARY KEY AUTO_INCREMENT,
  room_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL
);

CREATE TABLE room_service (
  id INT PRIMARY KEY AUTO_INCREMENT,
  service_name VARCHAR(100) UNIQUE,
  price DECIMAL(10,2)
);

CREATE TABLE food_service (
  id INT PRIMARY KEY AUTO_INCREMENT,
  meal_period VARCHAR(100) UNIQUE,
  price DECIMAL(10,2) 
);

CREATE TABLE booking (
  id INT PRIMARY KEY AUTO_INCREMENT,
  users_id INT NOT NULL,
  room_type_id VARCHAR(100) NOT NULL,
  room_service_id VARCHAR(100),
  food_service_id VARCHAR(100),
  booking_date DATETIME NOT NULL,
  checkin_date DATE NOT NULL,
  checkout_date DATE NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (users_id) REFERENCES users (id),
  FOREIGN KEY (room_type_id) REFERENCES room_type (id),
  FOREIGN KEY (room_service_id) REFERENCES room_service (id),
  FOREIGN KEY (food_service_id) REFERENCES food_service (id)
);

CREATE TABLE checkin (
  id INT PRIMARY KEY AUTO_INCREMENT,
  booking_id INT NOT NULL,
  checkin_date DATE NOT NULL,
  FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE
);

CREATE TABLE checkout (
  id INT PRIMARY KEY AUTO_INCREMENT,
  booking_id INT NOT NULL,
  checkout_date DATE NOT NULL,
  FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE
);

CREATE TABLE cancellation (
  id INT PRIMARY KEY AUTO_INCREMENT,
  booking_id INT NOT NULL,
  cancel_date DATE NOT NULL,
  FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE
);

CREATE TABLE invoice (
  id INT PRIMARY KEY AUTO_INCREMENT,
  users_id INT NOT NULL,
  booking_id INT NOT NULL,
  invoice_date DATE NOT NULL,
  payment_status VARCHAR(50),
  FOREIGN KEY (users_id) REFERENCES users (id),
  FOREIGN KEY (booking_id) REFERENCES booking (id)
);

CREATE TABLE payment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  booking_id INT NOT NULL,
  users_id INT NOT NULL,
  invoice_id INT NOT NULL,
  payment_method VARCHAR(50),
  FOREIGN KEY (booking_id) REFERENCES booking (id),
  FOREIGN KEY (users_id) REFERENCES users (id),
  FOREIGN KEY (invoice_id) REFERENCES invoice (id)
);
