1.Clone the repo

2.Run Command : composer install

3.Change DATABASE_URL in .env file

4.Run Command : bin/console doctrine:migrations:migrate

5.Run Command : symfony server:start

N/B:If running "symfony server:start", you get symfony not found Run This:
export PATH="$HOME/.symfony/bin:$PATH" & configure securityDemo

You can use the text files in the sampleTexts directory
