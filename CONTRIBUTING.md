# Before you send a pull request 

Running tests is easy:

```bash
make -j
```

This command will format all code as it should be, will run all necessary tests and checks. Just like it is done during CI for a PR.


# Integration tests

To run integration tests one must specify an access token in an environment variable:

```bash
export SHIPANDCO_ACCESS_TOKEN=...
```

Then it is recommended to run tests in a debugging mode:

```bash
vendor/bin/phpunit --group=integration --debug
```

This command will show requestes and responses as they happen.