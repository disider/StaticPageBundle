Feature: Admin can see the list of static pages

  Background:
    Given there are users:
      | email             | password    | role  |
      | user@example.com  | usersecret  | user  |
      | admin@example.com | adminsecret | admin |

  Scenario: Normal user cannot list the static pages
    Given I am logged as "user@example.com"
    When I visit "/pages/list"
    Then the response status code should be 403

  Scenario: Admin see the list of static pages
    Given I am logged as "admin@example.com"
    And there are static pages with:
      | title   | content               |
      | Example | This is a static page |
      | Dummy   | This is a dummy page  |
    When I visit "pages/list"
    Then I should see static pages with:
      | title | content              |
      | Dummy | This is a dummy page |