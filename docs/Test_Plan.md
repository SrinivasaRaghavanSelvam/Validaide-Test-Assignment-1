# 🧪 Test Plan – Validaide Take-Home Assignment

## 1. 📘 Objective

The objective of this test plan is to outline the testing approach for validating the Swag Labs (https://www.saucedemo.com/) platform using BDD practices. The goal is to implement a clean and maintainable automated test suite using **PHP**, **Behat**, and **Selenium**, aligned with the provided assignment requirements.

---

## 2. 🎯 Scope

This test suite covers the following functional areas of the Swag Labs platform:

- Login functionality
- Product sorting
- Checkout process
- Logout functionality

Out-of-scope:
- API testing
- Performance/load testing
- Non-functional validations (e.g., accessibility, security)

---

## 3. 🧰 Tools & Technology

| Tool         | Purpose                        |
|--------------|--------------------------------|
| PHP (8.x)    | Programming language           |
| Behat        | BDD framework for test scenarios |
| Selenium     | Browser automation             |
| ChromeDriver | WebDriver for Chrome           |
| Composer     | Dependency management          |

---

## 4. 🧪 Test Strategy

- **Approach**: Behavior-Driven Development (BDD) using Gherkin syntax and feature files
- **Test Automation**: Fully automated with reusable step definitions and page object patterns
- **Browser**: Google Chrome (headless or visible mode)
- **Execution**: Manual trigger using `vendor/bin/behat` from command line

---

## 5. 📋 Test Scenarios

| Feature              | Scenarios Tested |
|----------------------|------------------|
| Login                | - Invalid login<br>- Locked-out user<br>- Successful login |
| Product Sorting      | - Sort by name (Z to A)<br>- Verify descending order |
| Checkout Process     | - Add 2 items<br>- Validate item total and tax<br>- Complete order |
| Logout               | - User is logged out and redirected to login page |

---

## 6. ⚙️ Environment

- OS: Windows 11
- Browser: Chrome (latest)
- PHP: 8.0+
- Selenium: Standalone server (local)
- Composer: Latest version

---

## 7. 📄 Test Data

| Type        | Source                 |
|-------------|------------------------|
| Credentials | Hardcoded (test accounts)<br>_Planned to be externalized_ |
| Checkout    | `checkout_user.csv`    |

---

## 8. 🧱 Design Considerations

- Implemented Page Object Model (POM) for element locators to ensure maintainability
- Attempted to externalize config (e.g., URLs, credentials), but encountered PHP environment limitations

---

## 9. 🛠️ Execution

To run tests locally:

```bash
composer install
vendor/bin/behat
```

Tests are executed via CLI and report pass/fail results per scenario.

---

## 10. 📌 Known Limitations

- Configuration externalization (URL, credentials) not completed due to local PHP issues
- No CI/CD pipeline configured

---

## 11. ✅ Deliverables

- [x] Feature files (.feature)
- [x] Step definitions (PHP)
- [x] Page object abstraction
- [x] Test results screenshot
- [x] README documentation
- [x] This Test Plan

---

© 2025 – Srinivasa Raghavan Selvam
