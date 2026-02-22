# 🗳️ Online Voting System

A simple web-based voting system built with HTML, CSS, and PHP using XAMPP and MySQL.

## 📋 Features

- Vote for your favorite programming language (Python, Java, C++, JavaScript)
- Prevents double voting using PHP sessions
- Displays live results with a progress bar breakdown
- Clean, responsive UI

## 🛠️ Requirements

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)
- A web browser
- phpMyAdmin (included with XAMPP)

## 📁 File Structure

```
voting_system/
├── index.html       # Voting form (frontend)
├── styles.css       # Styling
├── db.php           # Database connection
├── vote.php         # Handles vote submission
└── results.php      # Displays voting results
```

## ⚙️ Setup & Installation

### 1. Place the project folder
Copy the `voting_system` folder into your XAMPP `htdocs` directory:
```
C:\xampp\htdocs\voting_system\
```

### 2. Start XAMPP
Open the XAMPP Control Panel and start both:
- **Apache**
- **MySQL**

### 3. Create the database
1. Go to `localhost/phpmyadmin` in your browser
2. Click **New** in the left sidebar
3. Name it `voting_system` and click **Create**
4. Click the **SQL** tab and run the following:

```sql
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    language VARCHAR(50) NOT NULL,
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4. Run the project
Open your browser and go to:
```
localhost/voting_system/
```

## 🗄️ Database Configuration

The default credentials in `db.php` match a standard XAMPP installation:

| Setting  | Value          |
|----------|----------------|
| Host     | localhost       |
| Username | root            |
| Password | *(empty)*       |
| Database | voting_system   |

If your XAMPP setup has a different username or password, update `db.php` accordingly.

## 🚀 Usage

1. Open `localhost/voting_system/` in your browser
2. Select a programming language and click **Submit Vote**
3. You'll be redirected to the results page automatically
4. Trying to vote again will show an "already voted" warning
5. You can always view results at `localhost/voting_system/results.php`

## ⚠️ Troubleshooting

**White screen after voting**
- Make sure Apache and MySQL are running in XAMPP
- Check that the database name in `db.php` is exactly `voting_system`
- Visit `localhost/voting_system/vote.php` directly to see any error messages

**Can't connect to database**
- Confirm phpMyAdmin is accessible at `localhost/phpmyadmin`
- Double check the credentials in `db.php`

**Page not loading**
- Make sure the folder is inside `C:\xampp\htdocs\`
- Confirm Apache is started in the XAMPP Control Panel

## 👥 Authors

- **Frontend** — HTML & CSS (index.html, styles.css)
- **Backend** — PHP & Database (db.php, vote.php, results.php)
