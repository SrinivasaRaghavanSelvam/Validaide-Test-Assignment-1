Feature: Checkout Process
  In order to purchase items
  As a user
  I need to be able to complete the checkout process

  Scenario: Complete checkout with two specific items and dynamic price verification
    Given I am logged in as a standard user
    When I add the product "Sauce Labs Backpack" to the cart and store its price
    And I add the product "Sauce Labs Bike Light" to the cart and store its price
    And I proceed to checkout
    And I fill in the checkout information from "checkout_user.csv"
    And I continue to the checkout overview
    Then the item total should be the sum of the stored prices
    And the final price should be the sum of the item total and the tax
    And I finish the checkout
    Then I should see the order completion message "Thank you for your order!"
