Feature: User registration
    In order to track my buyings
    As a visitor
    I need to be able to create an account in store

    Scenario: Successfully creating account in store
        Given I am on store homepage
         When I follow "Register"
         When I fill in the following:
            | Email        | foo@bar.com |
            | Username     | foo         |
            | Password     | bar         |
            | Verification | bar         |
        And I press "register"
       Then I should see "Welcome"

    Scenario: Trying to register with non verified password
        Given I am on store homepage
         When I follow "Register"
         When I fill in the following:
            | Email        | foo@bar.com |
            | Username     | foo         |
            | Password     | bar         |
            | Verification | foo         |
        And I press "register"
       Then I should be on registration page
        And I should see "This value is not valid"
