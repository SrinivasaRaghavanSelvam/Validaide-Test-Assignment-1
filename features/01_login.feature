Feature: Login Functionality
  In order to access the swag store
  As a user
  I need to be able to log in

  Scenario: Failed login with invalid credentials
    Given I am on the login page
    When I enter "invalid_user" into the "user-name" field
    And I enter "invalid_password" into the "password" field
    And I press "Login"
    Then I should see the error message "Epic sadface: Username and password do not match any user in this service"

  Scenario: Failed login with a locked out user
    Given I am on the login page
    When I enter "locked_out_user" into the "user-name" field
    And I enter "secret_sauce" into the "password" field
    And I press "Login"
    Then I should see the error message "Epic sadface: Sorry, this user has been locked out."

  Scenario: Successful login
    Given I am on the login page
    When I enter "standard_user" into the "user-name" field
    And I enter "secret_sauce" into the "password" field
    And I press "Login"
    Then I should be on the products page