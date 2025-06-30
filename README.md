# Validaide Test Assignment – Swag Labs Automation

## 📌 Project Overview

This project is a Behavior-Driven Development (BDD) test suite for [SauceDemo.com](https://www.saucedemo.com/), a demo e-commerce site provided by Sauce Labs. The tests were written using **PHP**, **Behat**, and **Selenium** to validate the Swag Labs platform functionality, simulating a user journey from login to checkout and logout.

---

## ✅ Assignment Summary

The following test scenarios were implemented as per the assignment requirements:

### 1. 🔐 Login Functionality
- ❌ Failed login with invalid credentials
- 🔒 Failed login with a locked-out user
- ✅ Successful login with a standard user
- 📢 Verified appropriate error messages for failed scenarios

### 2. 🔃 Product Sorting
- 🔠 Sorted products by name from Z to A
- ✔️ Verified the sorting order is descending (Z to A)

### 3. 🛒 Checkout Process
- ➕ Added two items to the cart: Sauce Labs Backpack and Sauce Labs Bike Light
- 💰 Verified total price and tax calculations
- 🧾 Completed the checkout process with user information
- 🎉 Verified order confirmation message

### 4. 🚪 Logout Functionality
- ✅ Verified that the user is logged out and returned to the login page

---

## 🧪 Test Results

![Test Results](assets/test-results.png)

```
6 scenarios (6 passed)
31 steps (31 passed)
0m6.62s (12.25Mb)
```

Each scenario executed successfully using Behat, verifying both UI behavior and business logic with Selenium.

---

## 🧰 Prerequisites

Make sure the following are installed on your machine:

- **PHP** (>= 8.0)
- **Composer** (Dependency manager for PHP)
- **Git**
- **Google Chrome** (or Firefox)
- **ChromeDriver** or **GeckoDriver**
- **Selenium Server** (or a Selenium-compatible WebDriver)
- Optional: **VS Code** or any PHP-compatible code editor

---

## 📥 How to Clone This Repository

```bash
git clone https://github.com/SrinivasaRaghavanSelvam/validaide-test-assignment.git
cd validaide-test-assignment
```

---

## ⚙️ Setup Instructions

1. Install PHP dependencies with Composer:
   ```bash
   composer install
   ```

2. Start the Selenium server in the background (headless or visible).

3. Run the test suite:
   ```bash
   vendor/bin/behat
   ```

---

## 🧾 Notes

- Tests use Gherkin syntax in `.feature` files for clarity and maintainability.
- PHP step definitions are implemented in `FeatureContext.php`.
- Includes logic for dynamic price validation during checkout.
- Fully automated and extensible for future test scenarios.

---

## 🔗 GitHub Repo

[GitHub – validaide-test-assignment](https://github.com/SrinivasaRaghavanSelvam/validaide-test-assignment)

---

© 2025 | Automation Test Suite by Srinivasa Raghavan Selvam
