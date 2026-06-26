```mermaid
erDiagram

USERS ||--o{ PENGADUAN : memiliki
USERS ||--o{ NOTIFICATIONS : menerima

USERS {
    bigint id
    varchar name
    varchar email
    varchar password
    enum role
}

PENGADUAN {
    bigint id
    bigint user_id
    varchar judul
    text deskripsi
    varchar foto
    varchar status
}

NOTIFICATIONS {
    bigint id
    bigint user_id
    text pesan
    boolean is_read
}
```