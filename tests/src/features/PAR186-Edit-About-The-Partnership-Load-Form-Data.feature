@ci
Feature: Edit About the Partnership: Load form data - As a Primary Authority Officer
    I need to be able to edit the field 'About the Partnership' in the existing partnership details
    So that the correct details are taken forward into the new PAR
    
    Background:
<<<<<<< HEAD
    Given I open url "/login"
    And I am logged in as PAR user "testuser" with password "testpwd"
=======
        Given I open the url "/user/login"
        And I add "testuser" to the inputfield "#edit-name"
        And I add "password" to the inputfield "#edit-pass"
        And I press "Login"
>>>>>>> master

    Scenario: Edit About the Partnership: Load form data
        Given I open the url "/dv/primary-authority-partnerships/1/partnership/1/details/edit-about"
        Then the element "h1" contains the text "Edit the information about the Partnership"
        And the element "#edit-next" is visible
