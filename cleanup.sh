#!/bin/bash
#
# Remove all code samples from the snippets folder. Execution should be automated in a cronjob.
#
SNIPPETS="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/snippets"

find "$SNIPPETS" -type f \! -name ".gitignore" -mtime +1 -delete
