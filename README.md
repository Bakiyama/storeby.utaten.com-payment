# STORE by UtaTen Payment

## Description

This repository is created for STORE by UtaTen rebuild project.  
So, this repository will not be released as production.  
Once storeby.utaten.com repository's development begins, this repository's logic will be implemented  
in the repository.

## Prerequisites

- ```php : ^8.0.2```
- ```composer : ^2.0.0```

## Installation
### DDEV
1. Clone a this repository.
```
git clone https://github.com/Bakiyama/storeby.utaten.com-payment.git
```
2. Create and Start a docker container by ddev.
```
ddev start
```
3. Generate Laravel's key
```
ddev artisan key:generate
```
4. Migrate
```
ddev artisan migrate
```
5. Start ngrok proxie
```
ddev share
```
