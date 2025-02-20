<?php

// All status
const QUOTATION_STATUS_CANCELED = 3;
const QUOTATION_STATUS_PAID = 4;

const CONVERSATION_TYPE_TEAM = 1;
const CONVERSATION_TYPE_CLIENT = 2;
const WORKING_STATUS_PENDING = 3;
const WORKING_STATUS_WORKING = 0;
const WORKING_STATUS_COMPLETED = 1;
const WORKING_STATUS_CANCELED = 2;
const TICKET_PRIORITY_LOW = 1;
const TICKET_PRIORITY_MEDIUM = 2;
const TICKET_PRIORITY_HIGH = 3;
const TICKET_STATUS_OPEN = 0;
const TICKET_STATUS_IN_PROGRESS = 1;
const TICKET_STATUS_ON_HOLD = 2;
const TICKET_STATUS_RESOLVED = 3;
const TICKET_STATUS_CLOSED = 4;
const TICKET_STATUS_RE_OPEN = 5;
const TICKET_STATUS_TRASHED = 6;

const ORDER_PAYMENT_STATUS_PENDING = 0;
const ORDER_PAYMENT_STATUS_PAID = 1;
const ORDER_PAYMENT_STATUS_CANCELLED = 2;

const INVOICE_MAIL_TYPE_UNPAID = 0;
const INVOICE_MAIL_TYPE_PAID = 1;
const PAYMENT_STATUS_PENDING = 0;
const PAYMENT_STATUS_PAID = 1;
const PAYMENT_STATUS_CANCELLED = 2;
const PAYMENT_STATUS_PARTIAL = 3;
const PAYMENT_STATUS_BANK = 'bank';

const STATUS_PENDING = 0;
const STATUS_ACTIVE = 1;
const STATUS_CANCELED = 2;
const STATUS_REJECT = 3;
const STATUS_DEACTIVATE = 4;
const STATUS_SUSPENDED = 5;
const STATUS_DISABLE = 6;

// User Role Type
const USER_STATUS_ACTIVE = 1;
const USER_STATUS_INACTIVE = 0;
const USER_STATUS_UNVERIFIED = 2;

const USER_ROLE_ADMIN = 1;
const USER_ROLE_TEAM_MEMBER = 2;
const USER_ROLE_CLIENT = 3;

// Message constant
// Message
const SOMETHING_WENT_WRONG = "Something went wrong! Please try again";
const CREATED_SUCCESSFULLY = "Created Successfully";
const FAVORITES_SUCCESSFULLY = "Image add to favorite list";
const FAVORITES_REMOVE_SUCCESSFULLY = "Image removed from favorite list";
const UPDATED_SUCCESSFULLY = "Updated Successfully";
const SUBMIT_SUCCESSFULLY = "Submit Successfully";
const STATUS_UPDATED_SUCCESSFULLY = "Status Updated Successfully";
const DELETED_SUCCESSFULLY = "Deleted Successfully";
const UPLOADED_SUCCESSFULLY = "Uploaded Successfully";
const DATA_FETCH_SUCCESSFULLY = "Data Fetch Successfully";
const SENT_SUCCESSFULLY = "Sent Successfully";
const PAY_SUCCESSFULLY = "Pay Successfully";
const ASSIGNED_SUCCESSFULLY = "Assigned Successfully";

const SEARCH_FOUND = "Search Found";
const SEARCH_NOT_FOUND = "No Search Found";
const DO_NOT_HAVE_PERMISSION = 7;

// Currency placement
const CURRENCY_SYMBOL_BEFORE = 1;
const CURRENCY_SYMBOL_AFTER = 2;

// storage driver
const STORAGE_DRIVER_PUBLIC = 'public';
const STORAGE_DRIVER_AWS = 'aws';
const STORAGE_DRIVER_WASABI = 'wasabi';
const STORAGE_DRIVER_VULTR = 'vultr';
const STORAGE_DRIVER_DO = 'do';

const ACTIVE = 1;
const INITIATE = 2;
const DEACTIVATE = 0;

//Billing Cycle
const BILLING_CYCLE_ONETIME = 1;
const BILLING_CYCLE_AUTO_RENEW = 2;
const BILLING_CYCLE_EXPIRE_AFTER = 3;

const DURATION_MONTH = 1;
const DURATION_YEAR = 2;

const BILLING_CYCLE_LIST = 1;
const BILLING_CYCLE_AUTO_GENERATED = 2;

const DISCOUNT_TYPE_FLAT = 1;
const DISCOUNT_TYPE_PERCENT = 2;

const TAX_TYPE_FLAT = 1;
const TAX_TYPE_PERCENT = 2;

const REDEMPTION_TYPE_ONETIME = 1;
const REDEMPTION_TYPE_FOREVER = 2;
const REDEMPTION_TYPE_LIMITED_NUMBER = 3;

const GATEWAY_MODE_LIVE = 1;
const GATEWAY_MODE_SANDBOX = 2;

//Gateway name
const PAYPAL = 'paypal';
const STRIPE = 'stripe';
const RAZORPAY = 'razorpay';
const INSTAMOJO = 'instamojo';
const MOLLIE = 'mollie';
const PAYSTACK = 'paystack';
const SSLCOMMERZ = 'sslcommerz';
const MERCADOPAGO = 'mercadopago';
const FLUTTERWAVE = 'flutterwave';
const BANK = 'bank';
const WALLET = 'wallet';
const COINBASE = 'coinbase';
const BINANCE = 'binance';
const ALIPAY = 'alipay';
const PAYTM = 'paytm';
const MAXICASH = 'maxicash';
const IYZICO = 'iyzico';
const BITPAY = 'bitpay';
const ZITOPAY = 'zitopay';
const PAYHERE = 'payhere';
const CINETPAY = 'cinetpay';
const VOGUEPAY = 'voguepay';
const TOYYIBPAY = 'toyyibpay';
const PAYMOB = 'paymob';
const AUTHORIZE = 'authorize';
const XENDIT = 'xendit';
const CASH = 'cash';
const PADDLE = 'paddle';

//Frontend settings Section id
const HERO_SECTION_ID = 1;
const TRADING_PLATFORM_SECTION_ID = 2;
const CRYPTOCURRENCY_SECTION_ID = 3;
const PAYMENT_SECTION_ID = 4;
const TRUSTED_PLATFORM_SECTION_ID = 5;
const NEWS_AND_ARTICLES_SECTION_ID = 6;
const GET_IN_TOUCH_SECTION_ID = 7;

const DEPOSIT_TYPE_BUY = 1;
const DEPOSIT_TYPE_DEPOSIT = 2;

const ORDER_TYPE_DEPOSIT = 1;
const ORDER_TYPE_HARDWARE = 2;
const ORDER_TYPE_PLAN = 3;

const RETURN_TYPE_FIXED = 1;
const RETURN_TYPE_RANDOM = 2;

const DELIVERY_STATUS_PENDING = 1;
const DELIVERY_STATUS_DELIVERED = 2;

const PAGE_ABOUT_US = 1;
const PAGE_PRIVACY_POLICY = 2;
const PAGE_TERMS_OF_SERVICE = 3;
const PAGE_COOKIE_POLICY = 4;
const PAGE_REFUND_POLICY = 5;

const EVENT_TYPE_FREE = 1;
const EVENT_TYPE_PAID = 2;

//employee status
const FULL_TIME = 1;
const PART_TIME = 2;
const CONTRACTUAL = 3;
const REMOTE_WORKER = 4;

//job post status
const JOB_STATUS_PENDING = 0;
const JOB_STATUS_APPROVED = 1;
const JOB_STATUS_CANCELED = 2;




// email templates
const EMAIL_TEMPLATE_PAYMENT_SUCCESS = 1;
const EMAIL_TEMPLATE_PAYMENT_FAILURE = 2;
const EMAIL_TEMPLATE_INVOICE = 3;
const EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION = 4;
const EMAIL_TEMPLATE_FORGOT_PASSWORD = 5;
const EMAIL_TEMPLATE_PAYMENT_CANCEL = 6;
const EMAIL_TEMPLATE_EMAIL_VERIFY = 7;

//webhook
const WEBHOOK_EVENT_TYPE_PAYMENT = 1;

const WEBHOOK_EVENT_STATUS_PENDING = 0;
const WEBHOOK_EVENT_STATUS_SUCCESS = 1;
const WEBHOOK_EVENT_STATUS_FAILED = 2;

//webhook

const STATUS_SUCCESS = 1;

// history status
const SMS_STATUS_DELIVERED = 1;
const SMS_STATUS_PENDING = 2;
const SMS_STATUS_FAILED = 3;

// checkout page status
const CHECKOUT_PAGE_SETTING_STATUS_ACTIVE = 1;
const CHECKOUT_PAGE_SETTING_STATUS_PENDING = 2;

const FORM_STEP_ONE = 1;
const FORM_STEP_TWO = 2;
const FORM_STEP_THREE = 3;
const FORM_STEP_FOUR = 4;
const FORM_STEP_FIVE = 5;
const FORM_STEP_SIX = 6;

// shipping
const SHIPPING_METHOD_FREE = 1;
const SHIPPING_METHOD_PAID = 2;

// invoice setting
const INVOICE_SETTING_TYPE_ORDER = 1;

// table column
const TABLE_COLUMN_PRODUCT = 1;
const TABLE_COLUMN_PLAN = 2;
const TABLE_COLUMN_PLAN_CODE = 3;
const TABLE_COLUMN_PRICE = 4;
const TABLE_COLUMN_QUANTITY = 5;
const TABLE_COLUMN_TOTAL = 6;
const TABLE_SETUP_FEE = 7;

const CHECKOUT_TYPE_USER_INVOICE = 2;
const CHECKOUT_TYPE_USER_PLAN = 3;
// checkout type

//task priority

const ORDER_TASK_PRIORITY_LOWEST = 5;
const ORDER_TASK_PRIORITY_LOW = 4;
const ORDER_TASK_PRIORITY_MEDIUM = 3;
const ORDER_TASK_PRIORITY_HIGH = 2;
const ORDER_TASK_PRIORITY_HIGHEST = 1;

const ORDER_TASK_STATUS_PENDING = 0;
const ORDER_TASK_STATUS_PROGRESS = 1;
const ORDER_TASK_STATUS_REVIEW = 2;
const ORDER_TASK_STATUS_DONE = 3;
const DEFAULT_COLOR = 1;
const CUSTOM_COLOR = 2;

const THEME_HOME_ONE = 1;
const THEME_HOME_TWO = 2;
const THEME_HOME_THREE = 3;
const CREATE_BY_ADMIN = 1;
const CREATE_BY_USER = 0;
const RECURRING_GATEWAY = ['stripe', 'paypal'];

