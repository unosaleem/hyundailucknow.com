CREATE DATABASE IF NOT EXISTS brhyundai
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE brhyundai;

CREATE TABLE IF NOT EXISTS leads (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  model VARCHAR(80) NULL,
  selected_offer_id BIGINT UNSIGNED NULL,
  full_name VARCHAR(120) NOT NULL,
  city VARCHAR(100) NOT NULL,
  mobile VARCHAR(10) NOT NULL,
  enquiry_type VARCHAR(40) NOT NULL DEFAULT 'Best Offer',
  source VARCHAR(40) NOT NULL DEFAULT 'Website',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_leads_created_at (created_at),
  INDEX idx_leads_mobile (mobile)
) ENGINE=InnoDB;
