#!/usr/bin/env bash
#
# Regenerate every example output from the schemas in example/schema/.
#
# For each example/schema/<name>.sql it writes into example/output/<name>/:
#   <name>.puml  (mysql:plantuml)
#   <name>.md    (mysql:markdown)
#   <name>.png   (mysql:image --type png)  -- requires a Java runtime
#   <name>.svg   (mysql:image --type svg)  -- requires a Java runtime
#
# Usage: ./example/generate.sh
#
set -euo pipefail

cd "$(dirname "$0")/.."

bin="php ./database-schema-visualization"

has_java=0
if java -version >/dev/null 2>&1; then
    has_java=1
fi

for sql in example/schema/*.sql; do
    name="$(basename "$sql" .sql)"
    out="example/output/$name"
    mkdir -p "$out"

    echo "Generating $name ..."
    $bin mysql:plantuml "$sql" > "$out/$name.puml"
    $bin mysql:markdown "$sql" > "$out/$name.md"

    if [ "$has_java" -eq 1 ]; then
        $bin mysql:image --type png "$sql" > "$out/$name.png"
        $bin mysql:image --type svg "$sql" > "$out/$name.svg"
    fi
done

if [ "$has_java" -eq 0 ]; then
    echo "WARNING: no Java runtime found - skipped PNG/SVG generation (mysql:image needs Java)."
fi
