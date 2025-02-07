<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('calculate_skewness')) {
    /**
     * Verilen veri kümesi için çarpıklık hesaplama fonksiyonu
     * @param array $data
     * @return float|object|int
     */
    function calculate_skewness(array $data = array()): float|object|int
    {
        // Eğer veri yoksa çarpıklık hesaplaması yapamayız
        if (empty($data)) {
            return 0;
        }

        $n = count($data); // Veri sayısını alıyoruz

        if ($n < 3) {
            return 0; // Çarpıklık için yeterli veri yok
        }

        // Verileri 'puan' anahtarına göre ayıklıyoruz
        $puanlar = array_column($data, 'puan');

        // Ortalama ve standart sapmayı hesapla
        $mean = array_sum($puanlar) / $n;
        $variance = 0;
        foreach ($puanlar as $value) {
            $variance += pow($value - $mean, 2);
        }
        $std_dev = sqrt($variance / $n);

        // Çarpıklık hesaplama
        $skewness = 0;
        foreach ($puanlar as $value) {
            $skewness += pow(($value - $mean) / $std_dev, 3);
        }

        // Çarpıklık değeri
        $skewness *= $n / (($n - 1) * ($n - 2));

        return $skewness;
    }
}

if (!function_exists('interpret_skewness')) {
    // Çarpıklık değerine göre yorum yapacak fonksiyon
    function interpret_skewness($skewness): string
    {
        if ($skewness > 1) {
            return 'Dağılım Sağa Çarpık (long tail right)';
        } elseif ($skewness < -1) {
            return 'Dağılım Sola Çarpık (long tail left)';
        } elseif ($skewness >= -1 && $skewness <= 1) {
            return 'Dağılım Simetrik';
        } else {
            return 'Çarpıklık Değeri Hesaplanamadı!';
        }
    }
}

if (!function_exists('determine_exam_difficulty')) {
    /**
     * Çarpıklık değerine göre sınavın zorluk derecesini belirleme fonksiyonu
     * @param $skewness
     * @return string
     */
    function determine_exam_difficulty($skewness): string
    {
        // Eğer çarpıklık değeri boş veya 0'dan küçükse boş döndür
        if ($skewness === "") {
            return "";
        }

        // Çarpıklık değerine göre zorluk derecesi belirleme
        if ($skewness <= 0) {
            return "Sınav Çok Kolay";
        } elseif ($skewness < 0.1) {
            return "Sınav Kolay ";
        } elseif ($skewness <= 0.25) {
            return "Sınav Zor";
        } else {
            return "Sınav Çok Zor";
        }
    }
}

if (!function_exists('determine_exam_difficultyy')) {
    function determine_exam_difficultyy($variance, $skewness): string
    {
        // Varyansa dayalı zorluk derecesi
        if ($variance > 200) {
            $difficulty = "Sınav Çok Zor";
        } elseif ($variance > 100) {
            $difficulty = "Sınav Orta Zor";
        } else {
            $difficulty = "Sınav Kolay";
        }

        // Çarpıklıkla zorluk yorumunu entegre et
        if ($skewness > 0.5) {
            $difficulty = "Sınav Kolay"; // Sağ çarpık = kolay
        } elseif ($skewness < -0.5) {
            $difficulty = "Sınav Zor"; // Sol çarpık = zor
        }

        return $difficulty;
    }
}

if (!function_exists('determine_exam_difficulty_based_on_variance')) {
    function determine_exam_difficulty_based_on_variance($variance): string
    {
        if ($variance < 5) {
            return "Sınav Kolay/Orta"; // Kolay ya da orta seviyede bir sınav
        } elseif ($variance >= 5 && $variance <= 10) {
            return "Sınav Orta Zor"; // Orta zorlukta bir sınav
        } else {
            return "Sınav Çok Zor"; // Zor bir sınav
        }
    }
}

if (!function_exists('pearson_correlation')) {
    /**
     * Pearson Korelasyonu hesaplamak için örnek PHP fonksiyonu
     * @param $scores1
     * @param $scores2
     * @return float|int|string
     */
    function pearson_correlation($scores1, $scores2): float|int|string
    {
        $n = count($scores1);

        // Eğer veri setleri farklı uzunlukta ise, hata döndür
        if ($n != count($scores2)) {
            return 'Veri setleri farklı uzunlukta!';
        }

        // Toplamları ve karelerini hesapla
        $sum_x = array_sum($scores1);
        $sum_y = array_sum($scores2);

        $sum_x_squared = array_sum(array_map(function ($x) {
            return $x * $x;
        }, $scores1));
        $sum_y_squared = array_sum(array_map(function ($y) {
            return $y * $y;
        }, $scores2));

        // Çarpımları topla
        $sum_xy = array_sum(array_map(function ($x, $y) {
            return $x * $y;
        }, $scores1, $scores2));

        // Pearson korelasyonunu hesapla
        $numerator = $sum_xy - (($sum_x * $sum_y) / $n);
        $denominator = sqrt(($sum_x_squared - ($sum_x * $sum_x) / $n) * ($sum_y_squared - ($sum_y * $sum_y) / $n));

        // Eğer payda sıfırsa, korelasyon sıfırdır
        if ($denominator == 0) {
            return 0;
        }

        return $numerator / $denominator;
    }
}

if (!function_exists('interpret_correlation')) {
    function interpret_correlation($correlation): string
    {
        if ($correlation >= 0.9) {
            return "Çok yüksek bir ilişki var.";
        } elseif ($correlation >= 0.7) {
            return "Yüksek bir ilişki var.";
        } elseif ($correlation >= 0.5) {
            return "Orta seviyede bir ilişki var.";
        } elseif ($correlation >= 0.3) {
            return "Düşük bir ilişki var.";
        } else {
            return "Çok düşük bir ilişki var.";
        }
    }
}

if (!function_exists('get_correlation_and_interpretation')) {
    // Kimya ve Coğrafya sınavları arasındaki korelasyonu hesaplayıp yorum yapma
    function get_correlation_and_interpretation($lesson1_scores, $lesson2_scores): array
    {
        $correlation = pearson_correlation($lesson1_scores, $lesson2_scores);

        // Korelasyon değerini yorumla
        $interpretation = interpret_correlation($correlation);

        return [
            'correlation' => $correlation,
            'interpretation' => $interpretation
        ];
    }
}

if (!function_exists('draw_bar_chart_yatay')) {
    /**
     * @param array $puan_dagilimi
     * @return string
     */
    function draw_bar_chart_yatay(array $puan_dagilimi = array()): string
    {
        // Genişlik ve yükseklik ayarları
        $width = 800;
        $height = 600;
        $bar_height = 30;
        $margin = 50;
        $label_margin = 140; // Etiketlerin genişliği

        // Grafik alanı oluştur
        $image = imagecreatetruecolor($width, $height);

        // Renk tanımları
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 0, 102, 204);

        // Arka planı beyaz yap
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Başlık ekle
        $font = 5;
        $title = "";//"PUAN DAGILIMI GRAFIGI";
        imagestring($image, $font, ($width / 2) - (strlen($title) * imagefontwidth($font)) / 2, 10, $title, $black);

        // Y eksenindeki puan aralıklarının toplam sayısını al
        $num_bars = count($puan_dagilimi);
        $max_value = max(array_column($puan_dagilimi, 'ogrenci_sayisi'));

        foreach ($puan_dagilimi as $index => $data) {
            $y1 = $margin + $index * ($bar_height + 20);
            $y2 = $y1 + $bar_height;
            $bar_width = ($data['ogrenci_sayisi'] / $max_value) * ($width - $label_margin - $margin);

            // Çubuğu çiz
            imagefilledrectangle($image, $label_margin, $y1, $label_margin + $bar_width, $y2, $gray);

            // Çubuk üstüne öğrenci sayısını yaz
            imagestring($image, $font, $label_margin + $bar_width + 10, $y1 + ($bar_height / 4), $data['ogrenci_sayisi'], $black);

            // Y eksenine puan aralıklarını yaz
            imagestring($image, $font, 10, $y1 + ($bar_height / 4), $data['puan_araligi'], $black);
        }

        // Y ekseni için çizgi çiz
        imageline($image, $label_margin, $margin - 10, $label_margin, $height - $margin, $black);

        // Grafiği dosya olarak kaydetme
        $upload_dir = FCPATH . 'uploads/graphs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Klasör yoksa oluştur
        }

        $file_path = $upload_dir . 'puan_dagilimi_' . time() . '.png';
        imagepng($image, $file_path);
        imagedestroy($image);

        // Dosya yolunu döndür
        return 'uploads/graphs/' . basename($file_path);
    }

    if (!function_exists('draw_bar_chart_dikey')) {
        /**
         * @param array $puan_dagilimi
         * @return string
         */
        function draw_bar_chart_dikey(array $puan_dagilimi = array()): string
        {
            // Genişlik ve yükseklik ayarları
            $width = 800;
            $height = 600;
            $bar_width = 50;
            $margin = 70;

            // Grafik alanı oluştur
            $image = imagecreatetruecolor($width, $height);

            // Renk tanımları
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            $blue = imagecolorallocate($image, 0, 102, 204);

            // Arka planı beyaz yap
            imagefilledrectangle($image, 0, 0, $width, $height, $white);

            // Yazı tipi dosyasının yolu (Proje klasöründeki bir font dosyasını kullanın)
            $font_file = FCPATH . 'assets/fonts/roboto-v20-latin-regular.ttf'; // Bu yolu kendi font dosyanızla değiştirin.

            if (!file_exists($font_file)) {
                die("Font dosyası bulunamadı: $font_file");
            }

            $font_size = 10; // Yazı tipi boyutu
            $chart_height = $height - 2 * $margin;

            // En büyük öğrenci sayısını al
            $max_value = max(array_column($puan_dagilimi, 'ogrenci_sayisi'));

            foreach ($puan_dagilimi as $index => $data) {
                $x1 = $margin + $index * ($bar_width + 20);
                $x2 = $x1 + $bar_width;
                $bar_height = ($data['ogrenci_sayisi'] / $max_value) * $chart_height;
                $y1 = $height - $margin - $bar_height;
                $y2 = $height - $margin;

                // Çubuğu çiz
                imagefilledrectangle($image, $x1, $y1, $x2, $y2, $blue);

                // Çubuğun üstüne öğrenci sayısını yaz
                imagettftext($image, $font_size, 0, $x1 + ($bar_width / 4), $y1 - 5, $black, $font_file, $data['ogrenci_sayisi']);

                // X eksenine puan aralıklarını 45 dereceyle yaz
                imagettftext($image, $font_size, 45, $x1-8, $y2 + 68, $black, $font_file, $data['puan_araligi']);
            }

            // Y eksenini çiz
            imageline($image, $margin, $margin, $margin, $height - $margin, $black);

            // X eksenini çiz
            imageline($image, $margin, $height - $margin, $width - $margin, $height - $margin, $black);

            // Grafiği dosyaya kaydet
            $upload_dir = FCPATH . 'uploads/graphs/';;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_path = $upload_dir . 'chart_' . time() . '.png';
            imagepng($image, $file_path);
            imagedestroy($image);

            return 'uploads/graphs/' . basename($file_path);
        }
    }

    if (!function_exists('plot_skewness_graph')) {
        /**
         * @param array $data
         * @return string
         */

        // Veritabanından puanları çekme ve çarpıklık grafiği oluşturma
        function plot_skewness_graph(array $data = array()): string
        {
            // Eğer puan verisi yoksa, işlem yapma
            if (empty($data)) {
                return "Veri yok.";
            }

            // Puanları diziye aktar
            $scores = array_map(function ($row) {
                return $row['puan'];
            }, $data);

            // Histogram için ayarları yap
            $width = 600;
            $height = 400;
            $padding = 50; // Kenar boşlukları

            // GD kütüphanesiyle bir resim oluştur
            $image = imagecreatetruecolor($width, $height);

            // Renkleri tanımla
            $background_color = imagecolorallocate($image, 255, 255, 255);
            $bar_color = imagecolorallocate($image, 0, 102, 204);
            $text_color = imagecolorallocate($image, 0, 0, 0);
            $label_color = imagecolorallocate($image, 255, 0, 0); // Öğrenci sayısı yazısı için kırmızı renk

            // Arka planı beyaz yap
            imagefill($image, 0, 0, $background_color);

            // Puan aralığını ve bin sayısını ayarla
            $num_bins = 10;
            $min_value = min($scores);
            $max_value = max($scores);
            $range = $max_value - $min_value;
            $bin_width = $range / $num_bins;

            // Bin sıklıklarını hesapla
            $frequencies = array_fill(0, $num_bins, 0);
            foreach ($scores as $score) {
                $bin = (int)(($score - $min_value) / $bin_width);
                if ($bin == $num_bins) {
                    $bin--; // Son bin için istisna
                }
                $frequencies[$bin]++;
            }

            // Maksimum frekans
            $max_frequency = max($frequencies);

            // Histogram çubuklarını çiz
            $bar_width = ($width - 2 * $padding) / $num_bins;
            for ($i = 0; $i < $num_bins; $i++) {
                $bar_height = ($frequencies[$i] / $max_frequency) * ($height - 2 * $padding);
                $x1 = $padding + $i * $bar_width;
                $y1 = $height - $padding;
                $x2 = $x1 + $bar_width - 2;
                $y2 = $height - $padding - $bar_height;

                // Çubukları çiz
                imagefilledrectangle($image, $x1, $y1, $x2, $y2, $bar_color);

                // X ekseni etiketlerini ekle (puan aralıkları)
                $bin_label = round($min_value + ($i * $bin_width)) . "-" . round($min_value + (($i + 1) * $bin_width));
                imagestring($image, 3, $x1, $height - 40, $bin_label, $text_color);

                // Çubukların üstüne öğrenci sayısını yazdır
                $student_count = $frequencies[$i];
                imagestring($image, 4, $x1 + ($bar_width / 4), $y2 - 15, $student_count, $label_color);
            }

            // Y ekseni etiketlerini ekle (frekans değerleri)
            for ($i = 0; $i <= $max_frequency; $i += ceil($max_frequency / 5)) {
                $y_pos = $height - $padding - ($i / $max_frequency) * ($height - 2 * $padding);
                imagestring($image, 3, 10, $y_pos, $i, $text_color);
            }

            // Ekseni çiz (X ve Y)
            imageline($image, $padding, $padding, $padding, $height - $padding, $text_color); // Y Ekseni
            imageline($image, $padding, $height - $padding, $width - $padding, $height - $padding, $text_color); // X Ekseni

            // Başlık ekle
            imagestring($image, 5, $width / 2 - 70, 10, "", $text_color);

            // Resmi kaydedeceğimiz dizin (public/uploads klasörü)
            $upload_path = FCPATH . 'uploads/graphs/';
            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true); // Klasör yoksa oluştur
            }

            // Resim adını oluştur
            $image_filename = 'skewness_' . $sinav_id . '.png';
            $image_path = $upload_path . $image_filename;

            // PNG olarak kaydet
            imagepng($image, $image_path);
            imagedestroy($image);

            // Resmin URL'sini döndür
            return base_url('uploads/graphs/' . $image_filename);
        }
    }
}
