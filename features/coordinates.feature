
Feature:
    In order to prove that the application is correctly worked
    As a user
    I want to get coordinates

    Scenario: It receives a response from Symfony's kernel
        When user sends a request to "https://localhost/coordinates?countryCode=pl&city=Warsaw&street=Optykow%205A&postcode=04175"
        Then the response should be received and valid with lat: "52.232016", lng: "21.1089529"

    Scenario: It receives a response from Symfony's kernel
        When user sends a request to "https://localhost/gmaps?countryCode=pl&city=Warsaw&street=Optykow%205A&postcode=04175"
        Then the response should be received and valid with lat: "52.232016", lng: "21.1089529"

    Scenario: It receives a response from Symfony's kernel
        When user sends a request to "https://localhost/hmaps?countryCode=pl&city=Warsaw&street=Optykow%205A&postcode=04175"
        Then the response should be received and valid with lat: "52.23202", lng: "21.10895"
