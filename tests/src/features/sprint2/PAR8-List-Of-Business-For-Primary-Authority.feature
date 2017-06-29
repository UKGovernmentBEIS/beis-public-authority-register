@Pending @journey1
Feature: As a Primary Authority Officer
    I want to be able to see, and select from, a list of my current Partnerships
    I can* review and confirm partnership details

    Background:
        Given I open the url "/login"
        And I add "PrimaryAuthority" to the inputfield "#username"
        And I add "password" to the inputfield "#password"
        And I press "Login"
        Then I expect that element "#logged-in-header" contains the text "Thank you for registering"

    Scenario: Create New Partnership
        Given I press "Continue"
        And I click on the checkbox "#toc"
        And I press "Continue"
        Then I expect that element "h1" contains the text "You need to review and confirm the following partnerships"
        And I expect that element "#your-partnerships" does exist
        And I expect that element "#partnership-status" does exist
        When I click on the radio "#partnership-1"
        And I press "Continue"
