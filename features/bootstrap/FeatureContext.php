<?php

use App\Page\SwagLabsPage;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Dotenv\Dotenv;
use PHPUnit\Framework\Assert;

class FeatureContext extends MinkContext implements Context
{
    private const BASE_URL = 'http://www.saucedemo.com';
    private const SWAG_USERNAME = 'standard_user';
    private const SWAG_PASSWORD = 'secret_sauce';

    private $storedPrices = [];

    public function __construct() {}

    /** @BeforeScenario */
    public function beforeScenario() {
        $this->storedPrices = [];
    }

    private function getPriceFromString(string $currencyString): float {
        return (float) preg_replace('/[^0-9.]/', '', $currencyString);
    }

    /** @Given I am on the login page */
    public function iAmOnTheLoginPage() {
        $this->visit(self::BASE_URL);
    }

    /** @When I enter :value into the :field field */
    public function iEnterIntoTheField($value, $field) {
        $fieldLocator = ($field === 'user-name') ? SwagLabsPage::USERNAME_INPUT : SwagLabsPage::PASSWORD_INPUT;
        
        if ($value === 'secret_sauce') {
            $value = self::SWAG_PASSWORD;
        }
        if ($value === 'standard_user') {
            $value = self::SWAG_USERNAME;
        }
        $this->fillField($fieldLocator, $value);
    }

    /** @Then I should be on the products page */
    public function iShouldBeOnTheProductsPage() {
        $this->getSession()->wait(5000, "document.querySelector('" . SwagLabsPage::INVENTORY_CONTAINER . "')");
        $this->assertSession()->elementExists('css', SwagLabsPage::INVENTORY_CONTAINER);
        $this->assertSession()->addressEquals(self::BASE_URL . '/inventory.html');
    }

    /** @Given I am logged in as a standard user */
    public function iAmLoggedInAsAStandardUser() {
        $this->iAmOnTheLoginPage();
        $this->fillField(SwagLabsPage::USERNAME_INPUT, self::SWAG_USERNAME);
        $this->fillField(SwagLabsPage::PASSWORD_INPUT, self::SWAG_PASSWORD);
        $this->pressButton(SwagLabsPage::LOGIN_BUTTON);
        $this->iShouldBeOnTheProductsPage();
    }
    
    /** @Then I should see the error message :message */
    public function iShouldSeeTheErrorMessage($message) {
        $element = $this->getSession()->getPage()->find('css', SwagLabsPage::ERROR_MESSAGE_CONTAINER);
        Assert::assertNotNull($element, "Error message container not found.");
        Assert::assertEquals($message, $element->getText(), "The error message does not match the expected text.");
    }
    
    /** @When I sort the products by :sortOption */
    public function iSortTheProductsBy($sortOption) {
        $sortContainer = $this->getSession()->getPage()->find('css', SwagLabsPage::PRODUCT_SORT_DROPDOWN);
        Assert::assertNotNull($sortContainer, 'Product sort dropdown not found');
        $sortContainer->selectOption($sortOption);
    }

    /** @Then the products should be sorted by name in descending order */
    public function theProductsShouldBeSortedByNameInDescendingOrder() {
        $productNameElements = $this->getSession()->getPage()->findAll('css', SwagLabsPage::INVENTORY_ITEM_NAME);
        $productNames = array_map(function($element) { return $element->getText(); }, $productNameElements);
        $sortedNames = $productNames;
        rsort($sortedNames);
        Assert::assertEquals($sortedNames, $productNames, "Products are not sorted by name in Z-A order.");
    }
    
    /** @When I add the product :productName to the cart and store its price */
    public function iAddTheProductToTheCartAndStoreItsPrice($productName) {
        $page = $this->getSession()->getPage();
        $productContainer = $page->find('xpath', "//div[normalize-space()='{$productName}']/ancestor::div[@class='inventory_item']");
        Assert::assertNotNull($productContainer, "Product container for '{$productName}' not found.");
        $priceElement = $productContainer->find('css', SwagLabsPage::INVENTORY_ITEM_PRICE);
        Assert::assertNotNull($priceElement, "Price element for '{$productName}' not found.");
        $price = $this->getPriceFromString($priceElement->getText());
        $this->storedPrices[] = $price;
        $productContainer->pressButton(SwagLabsPage::ADD_TO_CART_BUTTON);
    }
    
    /** @When I proceed to checkout */
    public function iProceedToCheckout() {
        $this->getSession()->getPage()->find('css', SwagLabsPage::SHOPPING_CART_ICON)->click();
        $checkoutButton = $this->getSession()->getPage()->find('css', SwagLabsPage::CHECKOUT_BUTTON);
        Assert::assertNotNull($checkoutButton, "Checkout button not found on cart page.");
        $checkoutButton->click();
    }
    
    /** @When I fill in the checkout information from :csvFile */
    public function iFillInTheCheckoutInformationFrom($csvFile) {
        $filePath = __DIR__ . '/../data/' . $csvFile;
        Assert::assertFileExists($filePath, "CSV file not found at: " . $filePath);
        $handle = fopen($filePath, 'r');
        Assert::assertNotFalse($handle, "Could not open the CSV file.");
        $headers = fgetcsv($handle);
        $userData = fgetcsv($handle);
        fclose($handle);
        Assert::assertNotFalse($userData, "No data row found in CSV file.");
        $userInfo = array_combine($headers, $userData);
        $this->getSession()->getPage()->fillField(SwagLabsPage::FIRST_NAME_INPUT, $userInfo['firstName']);
        $this->getSession()->getPage()->fillField(SwagLabsPage::LAST_NAME_INPUT, $userInfo['lastName']);
        $this->getSession()->getPage()->fillField(SwagLabsPage::POSTAL_CODE_INPUT, $userInfo['postalCode']);
    }
    
    /** @When I continue to the checkout overview */
    public function iContinueToTheCheckoutOverview() {
        $this->getSession()->getPage()->pressButton(SwagLabsPage::CONTINUE_BUTTON);
    }

    /** @Then the item total should be the sum of the stored prices */
    public function theItemTotalShouldBeTheSumOfTheStoredPrices() {
        $expectedTotal = array_sum($this->storedPrices);
        $itemTotalElement = $this->getSession()->getPage()->find('css', SwagLabsPage::ITEM_TOTAL_LABEL);
        Assert::assertNotNull($itemTotalElement, "Item total label not found.");
        $actualTotal = $this->getPriceFromString($itemTotalElement->getText());
        Assert::assertEquals($expectedTotal, $actualTotal, "Item total on page does not match the sum of stored prices.");
    }
    
    /** @Then the final price should be the sum of the item total and the tax */
    public function theFinalPriceShouldBeTheSumOfTheItemTotalAndTheTax() {
        $itemTotalElement = $this->getSession()->getPage()->find('css', SwagLabsPage::ITEM_TOTAL_LABEL);
        Assert::assertNotNull($itemTotalElement, "Item total label not found on checkout overview.");
        $itemTotal = $this->getPriceFromString($itemTotalElement->getText());
        $taxElement = $this->getSession()->getPage()->find('css', SwagLabsPage::TAX_LABEL);
        Assert::assertNotNull($taxElement, "Tax label not found on checkout overview.");
        $tax = $this->getPriceFromString($taxElement->getText());
        $finalPriceElement = $this->getSession()->getPage()->find('css', SwagLabsPage::FINAL_PRICE_LABEL);
        Assert::assertNotNull($finalPriceElement, "Final price label not found.");
        $actualFinalPrice = $this->getPriceFromString($finalPriceElement->getText());
        $expectedFinalPrice = $itemTotal + $tax;
        Assert::assertEqualsWithDelta($expectedFinalPrice, $actualFinalPrice, 0.001, "Final price does not equal the sum of item total and tax.");
    }
    
    /** @When I finish the checkout */
    public function iFinishTheCheckout() {
        $this->getSession()->getPage()->pressButton(SwagLabsPage::FINISH_BUTTON);
    }

    /** @Then I should see the order completion message :message */
    public function iShouldSeeTheOrderCompletionMessage($message) {
        $element = $this->getSession()->getPage()->find('css', SwagLabsPage::ORDER_COMPLETE_HEADER);
        Assert::assertNotNull($element, "Order completion element not found.");
        Assert::assertStringContainsString($message, $element->getText());
    }

    /**
     * @When I log out
     */
    public function iLogOut()
    {
        $this->getSession()->getPage()->pressButton(SwagLabsPage::MENU_BUTTON);
        // --- THIS IS THE FINAL FIX ---
        // Increased wait to 1 second to allow menu animation to complete.
        $this->getSession()->wait(5000, "document.getElementById('" . SwagLabsPage::LOGOUT_LINK . "') !== null");
        $this->getSession()->getPage()->clickLink(SwagLabsPage::LOGOUT_LINK);
    }

    /** @Then I should be returned to the login page */
    public function iShouldBeReturnedToTheLoginPage() {
        $this->assertSession()->addressEquals(self::BASE_URL . '/');
        $this->assertSession()->elementExists('css', SwagLabsPage::LOGIN_FORM_SUBMIT_BUTTON);
    }
}