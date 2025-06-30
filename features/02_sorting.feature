Feature: Product Sorting
  In order to find products easily
  As a user
  I want to be able to sort products

  Scenario: Sort products by name from Z to A
    Given I am logged in as a standard user
    When I sort the products by "Name (Z to A)"
    Then the products should be sorted by name in descending order