CREATE TABLE products {
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    main_price INT NOT NULL,
    old_price INT NOT NULL,
    discount INT,
    description TEXT
}