#!/usr/bin/env bash

set -euo pipefail

if [[ $# -lt 1 ]]; then
  echo "Usage: $0 <input-video> [output-dir]"
  exit 1
fi

INPUT_VIDEO="$1"
OUTPUT_DIR="${2:-public/video/hero-hls}"

mkdir -p "${OUTPUT_DIR}"

ffmpeg -y \
  -i "${INPUT_VIDEO}" \
  -filter_complex "[0:v]split=3[v1][v2][v3]; \
    [v1]scale=w=640:h=360:force_original_aspect_ratio=decrease[v360]; \
    [v2]scale=w=1280:h=720:force_original_aspect_ratio=decrease[v720]; \
    [v3]scale=w=1920:h=1080:force_original_aspect_ratio=decrease[v1080]" \
  -map "[v360]" -map 0:a? -c:v:0 libx264 -preset medium -profile:v:0 main -crf 22 -maxrate:v:0 800k -bufsize:v:0 1200k -c:a:0 aac -b:a:0 96k \
  -map "[v720]" -map 0:a? -c:v:1 libx264 -preset medium -profile:v:1 main -crf 21 -maxrate:v:1 2800k -bufsize:v:1 4200k -c:a:1 aac -b:a:1 128k \
  -map "[v1080]" -map 0:a? -c:v:2 libx264 -preset medium -profile:v:2 high -crf 20 -maxrate:v:2 5000k -bufsize:v:2 7500k -c:a:2 aac -b:a:2 192k \
  -g 48 -keyint_min 48 -sc_threshold 0 \
  -f hls \
  -hls_time 6 \
  -hls_playlist_type vod \
  -hls_flags independent_segments \
  -hls_segment_filename "${OUTPUT_DIR}/stream_%v/data%03d.ts" \
  -master_pl_name "master.m3u8" \
  -var_stream_map "v:0,a:0,name:360p v:1,a:1,name:720p v:2,a:2,name:1080p" \
  "${OUTPUT_DIR}/stream_%v.m3u8"

echo "HLS output written to ${OUTPUT_DIR}"

