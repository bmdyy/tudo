FROM debian:bookworm-slim

ARG TARGETARCH

RUN apt-get -q update && apt-get install -q -y \
    firefox-esr \
    python3-pip \
    cron \
    && pip3 install selenium --break-system-packages

RUN if [ "$TARGETARCH" = "arm64" ]; then \
        apt-get install -q -y curl && \
        curl -LO https://github.com/mozilla/geckodriver/releases/download/v0.36.0/geckodriver-v0.36.0-linux-aarch64.tar.gz && \
        tar -xvf geckodriver-v0.36.0-linux-aarch64.tar.gz && \
        rm -rf geckodriver-v0.36.0-linux-aarch64.tar.gz && \
        mv geckodriver /usr/bin/ && \
        chmod +x /usr/bin/geckodriver; \
    fi

COPY emulate.py /app/emulate.py
COPY emulate_arm64.py /app/emulate_arm64.py

RUN if [ "$TARGETARCH" = "arm64" ]; then \
        mv /app/emulate_arm64.py /app/emulate.py; \
    fi

COPY emulate.cron /etc/cron.d/emulate
RUN chmod 0644 /etc/cron.d/emulate
RUN crontab /etc/cron.d/emulate

CMD ["cron", "-f"]