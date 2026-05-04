# PHP URL Shortener

A lightweight and efficient URL shortening service built using PHP and MySQL.  
This project focuses on backend fundamentals such as performance optimization, security, and system design.

---

## Features

- Generate short URLs from long links
- Custom short codes (aliases)
- Automatic redirection system
- Click tracking and analytics
- Link expiry support
- Rate limiting to prevent abuse
- File-based caching for faster redirects
- Automatic cleanup of expired and inactive links
- Input validation and basic security practices

---

## Tech Stack

- PHP (Core backend logic)
- MySQL (Database)
- HTML/CSS (Frontend)
- JavaScript (optional enhancements)

---

## How It Works

1. User submits a long URL  
2. System generates or accepts a custom short code  
3. URL is stored in the database  
4. On access:
   - Cache is checked first for performance  
   - Database is used as fallback  
   - User is redirected to the original URL  
5. Clicks and last accessed time are tracked  
6. Background cleanup removes expired and unused links  

---

## Project Structure


/project-root
│
├── index.php # Main UI
├── save.php # URL creation logic
├── redirect.php # Redirection logic
├── analytics.php # View stored URLs
├── cleanup.php # Cleanup script
├── db.php # Database connection
├── functions.php # Helper functions
├── cache/ # Cached URL data
└── style.css # UI styling


---

## Database Setup

Create a MySQL database named:


url_shortener


Then create the following tables:

### urls
```sql
CREATE TABLE urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    long_url TEXT NOT NULL,
    short_code VARCHAR(10) UNIQUE,
    clicks INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NULL,
    last_clicked_at DATETIME NULL
);
```

### requests

```sql
CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45),
    request_time DATETIME
);
```

## Setup Instructions

1. Install XAMPP or any PHP server environment  
2. Place the project inside the `htdocs` directory  
3. Create the database and tables as shown above  
4. Start Apache and MySQL  
5. Run the project at:  

http://localhost/index.php


---

## Key Concepts Demonstrated

- Server-side validation  
- Prepared statements (SQL injection prevention)  
- Rate limiting using IP tracking  
- File-based caching for performance  
- Data lifecycle management (expiry and cleanup)  
- Basic system design principles  

---

## Future Improvements

- Pretty URLs (e.g., `/abc123` instead of query parameters)  
- Base62 encoding for short codes  
- Admin dashboard with improved analytics  
- API support  
- Redis-based caching  

---

## License

This project is intended for educational purposes.

