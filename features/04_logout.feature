Feature: Logout Functionality
  In order to protect my account
  As a logged in user
  I want to be able to log out

  Scenario: Successfully logging out
    Given I am logged in as a standard user
    When I log out
    Then I should be returned to the login page