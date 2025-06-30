<?php

namespace App\Page;

/**
 * Class SwagLabsPage
 * Holds all the element locators for the Swag Labs website.
 */
class SwagLabsPage
{
    // Login Page
    public const USERNAME_INPUT = 'user-name';
    public const PASSWORD_INPUT = 'password';
    public const LOGIN_BUTTON = 'Login';
    public const ERROR_MESSAGE_CONTAINER = '[data-test="error"]';
    public const LOGIN_FORM_SUBMIT_BUTTON = 'input[data-test="login-button"]'; // More specific for assertion

    // Products Page
    public const SHOPPING_CART_ICON = '#shopping_cart_container';
    public const PRODUCT_SORT_DROPDOWN = '.product_sort_container';
    public const INVENTORY_CONTAINER = '#inventory_container';
    public const INVENTORY_ITEM_NAME = '.inventory_item_name';
    public const INVENTORY_ITEM_PRICE = '.inventory_item_price';
    public const ADD_TO_CART_BUTTON = 'Add to cart';
    public const MENU_BUTTON = 'Open Menu';
    public const LOGOUT_LINK = 'logout_sidebar_link';

    // Cart & Checkout
    public const CHECKOUT_BUTTON = '#checkout';
    public const FIRST_NAME_INPUT = 'firstName';
    public const LAST_NAME_INPUT = 'lastName';
    public const POSTAL_CODE_INPUT = 'postalCode';
    public const CONTINUE_BUTTON = 'Continue';
    public const FINISH_BUTTON = 'Finish';
    public const ITEM_TOTAL_LABEL = '.summary_subtotal_label';
    public const TAX_LABEL = '.summary_tax_label';
    public const FINAL_PRICE_LABEL = '.summary_total_label';
    public const ORDER_COMPLETE_HEADER = '.complete-header';
}