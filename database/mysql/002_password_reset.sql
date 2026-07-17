USE vite_gourmand;

CREATE TABLE IF NOT EXISTS password_reset (
  id_password_reset INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(180) NOT NULL,
  token VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_password_reset_email (email)
) ENGINE=InnoDB;
