# Invest

## an investments platform MVP

![invest](investment-chart.jpg)

## Setup:

$ composer install

## Run tests

$ vendor/bin/phpunit

## Goals

- Each loan has a start date and anend date
- Each loan is split in multiple tranches
- Each tranche has a different monthly interest percentage
- Each tranche has a maximum amount available to invest, 
so once the maximum is reached, further investments can't be made in that tranche

- An investor, can invest in a tranche at any time if the loan it’s still open, the maximum
available amount was not reached and I have enough money in my virtual wallet
- At the end of the month it calculates the interest each investor is due to be paid


