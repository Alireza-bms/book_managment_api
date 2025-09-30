FROM ubuntu:latest
LABEL authors="arbms"

ENTRYPOINT ["top", "-b"]
