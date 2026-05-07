#!/usr/bin/env bash

set -euo pipefail

if [[ $# -lt 2 ]]; then
  echo "Usage: $0 <local-hls-dir> <s3://bucket/prefix>"
  exit 1
fi

LOCAL_DIR="$1"
S3_DESTINATION="$2"

aws s3 sync "${LOCAL_DIR}" "${S3_DESTINATION}" \
  --delete \
  --cache-control "public,max-age=31536000,immutable" \
  --exclude "*.m3u8" \
  --exclude "*.html"

aws s3 sync "${LOCAL_DIR}" "${S3_DESTINATION}" \
  --delete \
  --cache-control "public,max-age=60,s-maxage=60" \
  --exclude "*" \
  --include "*.m3u8"

echo "Uploaded HLS assets to ${S3_DESTINATION}"
