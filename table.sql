
--
-- Struktur dari tabel `traffic_data`
--

CREATE TABLE `traffic_data` (
  `id` int(6) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `is_mobile` tinyint(1) NOT NULL,
  `is_tablet` tinyint(1) NOT NULL,
  `is_wifi` tinyint(1) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `city` varchar(128) NOT NULL,
  `region` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeks untuk tabel `traffic_data`
--
ALTER TABLE `traffic_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `traffic_data`
--
