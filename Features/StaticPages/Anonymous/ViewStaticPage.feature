Feature: User can view the static pages

  Scenario: User can view a static page
    Given there are static pages with:
      | title    | content               |
      | Example | This is a static page |
    When I visit "/pages/view/example"
    Then I should see "This is a static page"

  Scenario: User cannot view unknown page
    When I visit "/pages/unknown"
    Then the response status code should be 404