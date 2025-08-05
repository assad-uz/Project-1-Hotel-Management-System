-- Table: role
CREATE TABLE role (
    id INT PRIMARY KEY,
    role_type VARCHAR(50)
);

-- Table: admin
CREATE TABLE admin (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    photo VARCHAR(255)
);

-- Table: user
CREATE TABLE user (
    id INT PRIMARY KEY,
    role_id INT,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    photo VARCHAR(255),
    FOREIGN KEY (role_id) REFERENCES role(id)
);

-- Table: bed_category
CREATE TABLE bed_category (
    id INT PRIMARY KEY,
    bed_name VARCHAR(50)
);

-- Table: food_service
CREATE TABLE food_service (
    id INT PRIMARY KEY,
    food_name VARCHAR(100),
    price DECIMAL(10,2)
);

-- Table: room_service
CREATE TABLE room_service (
    id INT PRIMARY KEY,
    service_name VARCHAR(100),
    price DECIMAL(10,2)
);

-- Table: service
CREATE TABLE service (
    id INT PRIMARY KEY,
    room_service_id INT,
    food_service INT,
    service_price DECIMAL(10,2),
    FOREIGN KEY (room_service_id) REFERENCES room_service(id),
    FOREIGN KEY (food_service) REFERENCES food_service(id)
);

-- Table: bed_info
CREATE TABLE bed_info (
    id INT PRIMARY KEY,
    bed_category_id INT,
    FOREIGN KEY (bed_category_id) REFERENCES bed_category(id)
);

-- Table: room_type
CREATE TABLE room_type (
    id INT PRIMARY KEY,
    room_name VARCHAR(100)
);

-- Table: room
CREATE TABLE room (
    id INT PRIMARY KEY,
    bed_id INT,
    service_id INT,
    room_id VARCHAR(50),
    room_number VARCHAR(50),
    room_price DECIMAL(10,2),
    room_status VARCHAR(50),
    description VARCHAR(255),
    photo VARCHAR(255),
    FOREIGN KEY (bed_id) REFERENCES bed_info(id),
    FOREIGN KEY (service_id) REFERENCES service(id)
);

-- Table: booking
CREATE TABLE booking (
    id INT PRIMARY KEY,
    user_id INT,
    room_id INT,
    booking_date DATETIME,
    checkin_date DATE,
    checkout_date DATE,
    payment_status VARCHAR(50),
    amount DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (room_id) REFERENCES room(id)
);

-- Table: cancellation
CREATE TABLE cancellation (
    id INT PRIMARY KEY,
    booking_id INT,
    cancel_date DATE,
    FOREIGN KEY (booking_id) REFERENCES booking(id)
);

-- Table: checkin
CREATE TABLE checkin (
    id INT PRIMARY KEY,
    booking_id INT,
    checkin_date DATE,
    FOREIGN KEY (booking_id) REFERENCES booking(id)
);

-- Table: checkout
CREATE TABLE checkout (
    id INT PRIMARY KEY,
    booking_id INT,
    checkout_date DATE,
    FOREIGN KEY (booking_id) REFERENCES booking(id)
);

-- Table: payment
CREATE TABLE payment (
    id INT PRIMARY KEY,
    booking_id INT,
    user_id INT,
    invoice_id INT,
    payment_method VARCHAR(50),
    FOREIGN KEY (booking_id) REFERENCES booking(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Table: transaction
CREATE TABLE transaction (
    id INT PRIMARY KEY,
    user_id INT,
    booking_id INT,
    payment_id INT,
    admin_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (booking_id) REFERENCES booking(id),
    FOREIGN KEY (payment_id) REFERENCES payment(id),
    FOREIGN KEY (admin_id) REFERENCES admin(id)
);

-- Table: invoice
CREATE TABLE invoice (
    id INT PRIMARY KEY,
    user_id INT,
    booking_id INT,
    invoice_date DATE,
    payment_status VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (booking_id) REFERENCES booking(id)
);
