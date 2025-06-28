# Flowchart Perhitungan SAW

Dokumen ini memvisualisasikan alur perhitungan metode SAW (Simple Additive Weighting) menggunakan **Mermaid**.

## Flowchart

```mermaid
flowchart TB
    A((Mulai))
    A --> B[Input Data Alternatif:<br/>• x[i][j] (nilai ter‑mapping)<br/>• w[j] (bobot)]
    B --> C[Hitung min_j & max_j<br/>per tiap kriteria]
    C --> D[Loop i = 1..n, j = 1..m]
    D --> E{Kriteria j bertipe<br/>"cost"?}
    E -- Yes --> F[r[i][j] = min_j / x[i][j]]
    E -- No  --> G[r[i][j] = x[i][j] / max_j]
    F --> H[Simpan r[i][j]]
    G --> H
    H --> I{j < m?}
    I -- Yes --> D
    I -- No  --> J{ i < n?}
    J -- Yes --> D
    J -- No  --> K[Hitung skor S[i] = Σ (w[j] × r[i][j])]
    K --> L[Urutkan alternatif<br/>berdasarkan S[i] menurun]
    L --> M[Tampilkan Output:<br/>• r[i][j]<br/>• S[i]<br/>• Ranking]
    M --> Z((Selesai))
```
