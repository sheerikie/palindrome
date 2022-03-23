## Features:

1.Upload text file
2.Get Palindromes and Highlights
3.Update and Delete your Files

## Instructions

1.Clone the repo

2.Run Command : composer install

3.Change DATABASE_URL in .env file

4.Run Command : bin/console doctrine:migrations:migrate

5.Run Command : symfony server:start

N/B:If running "symfony server:start", you get symfony not found Run This:
export PATH="$HOME/.symfony/bin:$PATH" & configure securityDemo

You can use the text files in the sampleTexts directory

# key

1.Symfony 5
2.UploadController
3.Palindrome Service
4.Highlight Service
5.Upload Entity
6.Doctrine DB
7.Form & html rendered twig

# others

1.screenshot folder:contains app screenshot

2.sample texts folder:contains palindromes to test
