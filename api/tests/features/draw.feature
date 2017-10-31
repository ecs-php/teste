Feature: winner

  Scenario Outline: as a httpClient i need to insert a draw
    Given post metadata <date>, <winner_id>
    Then I shoud get a winner from database
    Examples:
      | date       | winner_id |
      | 1875-05-12 | 1         |

  Scenario: as a httpClient i need to retrieve a list of draws
    Given A get request
    Then I should see a list of draws from database
