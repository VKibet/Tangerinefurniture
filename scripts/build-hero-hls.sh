#!/usr/bin/env bash

set -euo pipefail

if [[ $# -lt 1 ]]; then
  echo "Usage: $0 <input-video> [output-dir]"
  exit 1
fi

INPUT_VIDEO="$1"
OUTPUT_DIR="${2:-public/video/hero-hls}"

mkdir -p "${OUTPUT_DIR}"

mkdir -p \
  "${OUTPUT_DIR}/stream_240x426" \
  "${OUTPUT_DIR}/stream_360x640" \
  "${OUTPUT_DIR}/stream_540x960" \
  "${OUTPUT_DIR}/stream_720x1280"

ffmpeg -y \
  -i "${INPUT_VIDEO}" \
  -filter_complex "[0:v]split=4[v1][v2][v3][v4]; \
    [v1]scale=w=240:h=426:force_original_aspect_ratio=decrease[v240]; \
    [v2]scale=w=360:h=640:force_original_aspect_ratio=decrease[v360]; \
    [v3]scale=w=540:h=960:force_original_aspect_ratio=decrease[v540]; \
    [v4]scale=w=720:h=1280:force_original_aspect_ratio=decrease[v720]" \
  -map "[v240]" -c:v:0 libx264 -preset medium -profile:v:0 main -crf 24 -maxrate:v:0 450k -bufsize:v:0 900k \
  -map "[v360]" -c:v:1 libx264 -preset medium -profile:v:1 main -crf 23 -maxrate:v:1 900k -bufsize:v:1 1800k \
  -map "[v540]" -c:v:2 libx264 -preset medium -profile:v:2 main -crf 22 -maxrate:v:2 1600k -bufsize:v:2 3200k \
  -map "[v720]" -c:v:3 libx264 -preset medium -profile:v:3 high -crf 21 -maxrate:v:3 2800k -bufsize:v:3 5600k \
  -g 48 -keyint_min 48 -sc_threshold 0 \
  -f hls \
  -hls_time 6 \
  -hls_playlist_type vod \
  -hls_flags independent_segments \
  -hls_segment_filename "${OUTPUT_DIR}/stream_%v/data%03d.ts" \
  -master_pl_name "master.m3u8" \
  -var_stream_map "v:0,name:240x426 v:1,name:360x640 v:2,name:540x960 v:3,name:720x1280" \
  "${OUTPUT_DIR}/stream_%v.m3u8"

echo "HLS output written to ${OUTPUT_DIR}"
