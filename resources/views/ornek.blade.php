import React, { useState } from 'react';
import { 
  Search, ShoppingCart, User, Menu, Star, 
  ShieldCheck, Truck, CreditCard, ChevronRight, 
  Monitor, Gem, Sparkles, Droplets, BookOpen, Heart,
  Gift, Facebook, Twitter, Instagram, Mail, Phone, MapPin,
  ChevronLeft, Minus, Plus, Check, ThumbsUp, RefreshCw, AlertCircle
} from 'lucide-react';

export default function App() {
  const [activeCategory, setActiveCategory] = useState('Tümü');
  const [view, setView] = useState('home');
  const [quantity, setQuantity] = useState(1);
  const [activeTab, setActiveTab] = useState('ozellikler');

  const categories = [
    'Tümü', 'Dijital Hizmetler', 'Takı & Mücevher', 'Kişisel Bakım', 'Dini Ürünler', 'Ev & Yaşam'
  ];

  const featuredProducts = [
    { id: 1, name: "Zirkon Taşlı Gümüş Kolye", price: "850 TL", category: "Takı", icon: <Gem size={32} className="text-amber-500" />, color: "bg-amber-100" },
    { id: 2, name: "Bambu Ekolojik Diş Fırçası Seti", price: "120 TL", category: "Kişisel Bakım", icon: <Sparkles size={32} className="text-emerald-500" />, color: "bg-emerald-100" },
    { id: 3, name: "Oltu Taşı Gümüş Püsküllü Tesbih", price: "450 TL", category: "Dini Ürünler", icon: <BookOpen size={32} className="text-stone-600" />, color: "bg-stone-200" },
    { id: 4, name: "Organik Yüz Temizleme Jeli", price: "240 TL", category: "Güzellik", icon: <Droplets size={32} className="text-rose-400" />, color: "bg-rose-100" },
  ];

  return (
    <div className="min-h-screen bg-gray-50 font-sans text-gray-800">
      
      {/* HEADER / NAVBAR */}
      <header className="bg-white shadow-sm sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-20">
            {/* Logo */}
            <div className="flex-shrink-0 flex items-center gap-2 cursor-pointer" onClick={() => setView('home')}>
              <div className="w-10 h-10 bg-rose-600 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-rose-200">
                <Gift size={24} />
              </div>
              <span className="font-extrabold text-2xl tracking-tight text-gray-900 hidden sm:block">
                hediyeme<span className="text-rose-600">.com</span>
              </span>
            </div>

            {/* Geniş Arama Çubuğu */}
            <div className="flex-1 max-w-2xl mx-8 hidden md:flex">
              <div className="relative w-full">
                <input 
                  type="text" 
                  placeholder="Ürün, kategori veya dijital hizmet arayın..." 
                  className="w-full pl-12 pr-4 py-3 rounded-full border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-rose-500 focus:ring-0 transition-all outline-none"
                />
                <Search className="absolute left-4 top-3.5 text-gray-400" size={20} />
                <button className="absolute right-2 top-2 bg-rose-600 text-white px-5 py-1.5 rounded-full text-sm font-medium hover:bg-rose-700 transition shadow-md shadow-rose-200">
                  Ara
                </button>
              </div>
            </div>

            {/* İkonlar */}
            <div className="flex items-center gap-4 sm:gap-6">
              <button className="md:hidden text-gray-600 hover:text-rose-600"><Search size={24} /></button>
              <button className="text-gray-600 hover:text-rose-600 flex flex-col items-center gap-1">
                <User size={22} />
                <span className="text-[10px] font-medium hidden sm:block">Hesabım</span>
              </button>
              <button className="text-gray-600 hover:text-rose-600 flex flex-col items-center gap-1 relative">
                <div className="relative">
                  <ShoppingCart size={22} />
                  <span className="absolute -top-2 -right-2 bg-rose-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white">3</span>
                </div>
                <span className="text-[10px] font-medium hidden sm:block">Sepetim</span>
              </button>
            </div>
          </div>
        </div>

        {/* Kategori Navigasyonu */}
        <div className="border-t border-gray-100">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex space-x-8 overflow-x-auto py-3 no-scrollbar">
              <button className="flex items-center gap-2 text-rose-600 font-bold whitespace-nowrap">
                <Menu size={18} /> Tüm Kategoriler
              </button>
              {categories.slice(1).map((cat) => (
                <button key={cat} className="text-gray-600 hover:text-rose-600 font-medium whitespace-nowrap transition">
                  {cat}
                </button>
              ))}
            </div>
          </div>
        </div>
      </header>

      {/* ANASAYFA GÖRÜNÜMÜ */}
      {view === 'home' && (
        <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
          
          {/* HERO SECTION - BENTO BOX UI */}
          <section className="grid grid-cols-1 md:grid-cols-4 gap-4 h-auto md:h-[480px]">
            {/* Ana Vurgu (Dijital Hizmet) */}
            <div className="md:col-span-2 md:row-span-2 bg-gradient-to-br from-gray-900 via-gray-800 to-rose-900 rounded-3xl p-8 text-white flex flex-col justify-between relative overflow-hidden group cursor-pointer shadow-xl">
              <div className="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <Monitor size={200} />
              </div>
              <div className="relative z-10">
                <span className="bg-rose-500/30 text-rose-100 text-xs font-bold px-3 py-1 rounded-full border border-rose-400/30 backdrop-blur-sm">Dijital Çözümler</span>
                <h1 className="text-4xl sm:text-5xl font-extrabold mt-6 leading-tight">
                  Profesyonel <br/><span className="text-transparent bg-clip-text bg-gradient-to-r from-rose-300 to-rose-100">E-Ticaret</span> Siteniz Hazır!
                </h1>
                <p className="mt-4 text-gray-300 max-w-sm">Tasarım, altyapı ve SEO kurulumu dahil anahtar teslim web tasarım paketleri.</p>
              </div>
              <div className="relative z-10 mt-8">
                <button className="bg-white text-gray-900 px-6 py-3 rounded-full font-bold shadow-lg hover:bg-rose-50 hover:text-rose-700 transition flex items-center gap-2">
                  Paketleri İncele <ChevronRight size={18} />
                </button>
              </div>
            </div>

            {/* Güzellik & Takı Kutusu */}
            <div className="bg-rose-50 rounded-3xl p-6 flex flex-col justify-between cursor-pointer hover:shadow-md transition group">
              <div className="flex justify-between items-start">
                <div>
                  <span className="text-rose-600 text-xs font-bold px-2 py-1 rounded-full bg-rose-200/50">Güzellik & Takı</span>
                  <h3 className="text-xl font-bold mt-2 text-gray-800 group-hover:text-rose-600 transition">Zarafetinizi Taçlandırın</h3>
                </div>
                <div className="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-rose-500">
                  <Heart size={24} />
                </div>
              </div>
              <p className="text-sm text-gray-500 mt-4">%40'a varan indirimler</p>
            </div>

            {/* Günlük Yaşam (Diş Fırçası vb) */}
            <div className="bg-emerald-50 rounded-3xl p-6 flex flex-col justify-between cursor-pointer hover:shadow-md transition group">
              <div className="flex justify-between items-start">
                <div>
                  <span className="text-emerald-700 text-xs font-bold px-2 py-1 rounded-full bg-emerald-200/50">Günlük İhtiyaç</span>
                  <h3 className="text-xl font-bold mt-2 text-gray-800 group-hover:text-emerald-600 transition">Doğal Bakım Ürünleri</h3>
                </div>
                <div className="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-emerald-500">
                  <Sparkles size={24} />
                </div>
              </div>
              <p className="text-sm text-gray-500 mt-4">Çevre dostu seçimler</p>
            </div>

            {/* Dini Ürünler Kutusu */}
            <div className="md:col-span-2 bg-stone-100 rounded-3xl p-6 flex items-center justify-between cursor-pointer hover:shadow-md transition group overflow-hidden relative">
              <div className="relative z-10 w-2/3">
                <span className="text-stone-600 text-xs font-bold px-2 py-1 rounded-full bg-stone-200">Koleksiyon</span>
                <h3 className="text-2xl font-bold mt-2 text-gray-800">Özel Tasarım Tesbihler & Dini Eserler</h3>
                <p className="text-sm text-gray-500 mt-2">Usta işi, garantili oltu ve kehribar.</p>
              </div>
              <div className="w-24 h-24 bg-stone-200 rounded-full flex items-center justify-center relative z-10 group-hover:scale-110 transition-transform">
                 <BookOpen size={40} className="text-stone-500" />
              </div>
              <div className="absolute right-0 -bottom-10 opacity-5 text-stone-900 group-hover:opacity-10 transition-opacity">
                 <BookOpen size={150} />
              </div>
            </div>
          </section>

          {/* GÜVEN & HİZMET ROZETLERİ */}
          <section className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-gray-100">
              <div className="flex flex-col items-center gap-2 px-2">
                <div className="w-10 h-10 bg-rose-50 rounded-full flex items-center justify-center text-rose-600"><ShieldCheck size={20} /></div>
                <h4 className="font-bold text-sm text-gray-800">Güvenli Alışveriş</h4>
                <p className="text-xs text-gray-500">256-bit SSL Koruması</p>
              </div>
              <div className="flex flex-col items-center gap-2 px-2">
                <div className="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600"><Truck size={20} /></div>
                <h4 className="font-bold text-sm text-gray-800">Hızlı Kargo</h4>
                <p className="text-xs text-gray-500">Aynı gün teslimat seçeneği</p>
              </div>
              <div className="flex flex-col items-center gap-2 px-2">
                <div className="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600"><Monitor size={20} /></div>
                <h4 className="font-bold text-sm text-gray-800">Anında Teslimat</h4>
                <p className="text-xs text-gray-500">Dijital ürünlerde anında kurulum</p>
              </div>
              <div className="flex flex-col items-center gap-2 px-2">
                <div className="w-10 h-10 bg-stone-100 rounded-full flex items-center justify-center text-stone-600"><CreditCard size={20} /></div>
                <h4 className="font-bold text-sm text-gray-800">Taksit İmkanı</h4>
                <p className="text-xs text-gray-500">Tüm kartlara 12 ay taksit</p>
              </div>
            </div>
          </section>

          {/* FIRSAT ÜRÜNLERİ (SWIMLANE) */}
          <section>
            <div className="flex justify-between items-end mb-6">
              <div>
                <h2 className="text-2xl font-bold text-gray-900">Karma Fırsatlar</h2>
                <p className="text-gray-500 text-sm mt-1">Farklı kategorilerden sizin için seçilenler</p>
              </div>
              <button className="text-rose-600 font-medium text-sm flex items-center hover:underline">
                Tümünü Gör <ChevronRight size={16} />
              </button>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {featuredProducts.map((product) => (
                <div key={product.id} onClick={() => setView('product')} className="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group cursor-pointer">
                  <div className={`w-full h-48 ${product.color} rounded-xl mb-4 flex items-center justify-center group-hover:scale-[1.02] transition-transform`}>
                    {/* Gerçek resim yerine ikonik görsel tutucu */}
                    <div className="w-20 h-20 bg-white/50 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm">
                      {product.icon}
                    </div>
                  </div>
                  <div className="flex justify-between items-start mb-2">
                    <span className="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded">{product.category}</span>
                    <div className="flex text-amber-400">
                      <Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" />
                    </div>
                  </div>
                  <h3 className="font-bold text-gray-800 line-clamp-2 h-10 mb-2">{product.name}</h3>
                  <div className="flex items-center justify-between mt-4">
                    <span className="text-lg font-extrabold text-rose-600">{product.price}</span>
                    <button className="bg-gray-900 text-white p-2 rounded-xl hover:bg-rose-600 transition-colors">
                      <ShoppingCart size={18} />
                    </button>
                  </div>
                </div>
              ))}
            </div>
          </section>
        </main>
      )}

      {/* ÜRÜN DETAY GÖRÜNÜMÜ */}
      {view === 'product' && (
        <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          {/* Breadcrumb */}
          <nav className="flex items-center text-sm text-gray-500 mb-8 gap-2">
            <button onClick={() => setView('home')} className="hover:text-rose-600 flex items-center gap-1 transition font-medium">
              <ChevronLeft size={16} /> Anasayfa
            </button>
            <span>/</span>
            <span className="hover:text-rose-600 cursor-pointer">Takı & Mücevher</span>
            <span>/</span>
            <span className="text-gray-900 font-medium">Zirkon Taşlı Gümüş Kolye</span>
          </nav>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {/* Sol: Görsel Galerisi */}
            <div className="space-y-4">
              <div className="w-full aspect-square bg-amber-50 rounded-3xl flex items-center justify-center border border-amber-100 relative group overflow-hidden">
                 <div className="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-xs font-bold text-rose-600 shadow-sm z-10">%15 İndirim</div>
                 <div className="absolute top-4 right-4 bg-white p-2 rounded-full text-gray-400 hover:text-rose-500 cursor-pointer shadow-sm z-10 transition">
                    <Heart size={20} />
                 </div>
                 <Gem size={120} className="text-amber-400 group-hover:scale-110 transition-transform duration-500" />
              </div>
              <div className="grid grid-cols-4 gap-4">
                {[1, 2, 3, 4].map(idx => (
                  <div key={idx} className={`aspect-square rounded-2xl flex items-center justify-center cursor-pointer border-2 transition ${idx === 1 ? 'border-rose-500 bg-amber-50' : 'border-transparent bg-gray-100 hover:border-gray-300'}`}>
                    <Gem size={32} className={idx === 1 ? 'text-amber-400' : 'text-gray-400'} />
                  </div>
                ))}
              </div>
            </div>

            {/* Sağ: Ürün Bilgileri */}
            <div className="flex flex-col">
              <div className="mb-6">
                <span className="text-rose-600 font-bold text-sm tracking-wider uppercase bg-rose-50 px-2 py-1 rounded">hediyeme Özel</span>
                <h1 className="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-4 leading-tight">Zirkon Taşlı Zarif Gümüş Kolye</h1>
                <div className="flex items-center gap-4 mt-4">
                  <div className="flex text-amber-400">
                    <Star size={18} fill="currentColor" /><Star size={18} fill="currentColor" /><Star size={18} fill="currentColor" /><Star size={18} fill="currentColor" /><Star size={18} className="text-gray-300" />
                  </div>
                  <span className="text-sm text-indigo-600 hover:underline cursor-pointer font-medium">128 Değerlendirme</span>
                  <span className="text-gray-300">|</span>
                  <span className="text-sm text-emerald-600 font-bold flex items-center gap-1"><Check size={16} /> Stokta (Aynı Gün Kargo)</span>
                </div>
              </div>

              <div className="mb-6">
                <div className="flex items-end gap-3">
                  <span className="text-4xl font-extrabold text-rose-600">850 TL</span>
                  <span className="text-xl text-gray-400 line-through mb-1 font-medium">1.000 TL</span>
                </div>
                <p className="text-sm text-emerald-600 mt-2 font-medium flex items-center gap-1"><Sparkles size={16}/> Sepette ek %10 indirim fırsatını kaçırmayın!</p>
              </div>

              <div className="border-t border-b border-gray-100 py-6 mb-6 space-y-4">
                <p className="text-gray-600 leading-relaxed">
                  Sevdiklerinize unutulmaz bir hediye verin. 925 ayar gümüş üzeri rose gold kaplama, el işçiliği ile mıhlanmış A+ kalite zirkon taşlı bu kolye, zarif tasarımıyla her kombine uyum sağlar.
                </p>
                <ul className="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 font-medium mt-4">
                  <li className="flex items-center gap-3"><div className="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600"><Check size={14} /></div> Özel Hediye Paketi</li>
                  <li className="flex items-center gap-3"><div className="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600"><Check size={14} /></div> Kararma Yapmaz</li>
                  <li className="flex items-center gap-3"><div className="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600"><Check size={14} /></div> 2 Yıl Garanti</li>
                  <li className="flex items-center gap-3"><div className="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600"><Check size={14} /></div> Sertifikalı Ürün</li>
                </ul>
              </div>

              {/* Aksiyon Alanı */}
              <div className="flex flex-col sm:flex-row gap-4 mb-8">
                <div className="flex items-center border-2 border-gray-200 rounded-xl px-2 w-full sm:w-32 bg-white h-14">
                  <button onClick={() => setQuantity(Math.max(1, quantity - 1))} className="p-2 text-gray-500 hover:text-rose-600 transition h-full flex items-center"><Minus size={20} /></button>
                  <input type="text" value={quantity} readOnly className="w-full text-center font-bold text-gray-800 focus:outline-none text-lg bg-transparent" />
                  <button onClick={() => setQuantity(quantity + 1)} className="p-2 text-gray-500 hover:text-rose-600 transition h-full flex items-center"><Plus size={20} /></button>
                </div>
                <button className="flex-1 bg-rose-600 text-white font-bold text-lg rounded-xl flex items-center justify-center gap-2 hover:bg-rose-700 transition shadow-lg shadow-rose-200 h-14 hover:-translate-y-0.5">
                  <ShoppingCart size={22} /> Sepete Ekle
                </button>
              </div>

              <div className="bg-gray-50 border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
                 <ShieldCheck size={28} className="text-indigo-600 flex-shrink-0 mt-1" />
                 <div>
                    <h4 className="text-base font-bold text-gray-900">hediyeme.com Güvencesi</h4>
                    <p className="text-sm text-gray-500 mt-1 leading-relaxed">Bu ürün hediyeme.com kalite standartları kontrolünden geçmiştir. 14 gün içinde koşulsuz şartsız iade edilebilir.</p>
                 </div>
              </div>

            </div>
          </div>
          
          {/* Ürün Detay Sekmeleri (Tab Görünümü) */}
          <div className="mt-16 border-t border-gray-200 pt-12">
            <div className="flex space-x-8 border-b border-gray-200 mb-8 overflow-x-auto no-scrollbar">
              <button 
                onClick={() => setActiveTab('ozellikler')}
                className={`font-bold pb-4 px-2 whitespace-nowrap text-lg transition-colors ${activeTab === 'ozellikler' ? 'text-rose-600 border-b-2 border-rose-600' : 'text-gray-500 hover:text-gray-800'}`}
              >
                Ürün Özellikleri
              </button>
              <button 
                onClick={() => setActiveTab('degerlendirmeler')}
                className={`font-bold pb-4 px-2 whitespace-nowrap text-lg transition-colors ${activeTab === 'degerlendirmeler' ? 'text-rose-600 border-b-2 border-rose-600' : 'text-gray-500 hover:text-gray-800'}`}
              >
                Değerlendirmeler (128)
              </button>
              <button 
                onClick={() => setActiveTab('iade')}
                className={`font-bold pb-4 px-2 whitespace-nowrap text-lg transition-colors ${activeTab === 'iade' ? 'text-rose-600 border-b-2 border-rose-600' : 'text-gray-500 hover:text-gray-800'}`}
              >
                İade & Değişim
              </button>
            </div>
            
            {/* 1. SEKM: ÜRÜN ÖZELLİKLERİ */}
            {activeTab === 'ozellikler' && (
              <div className="grid grid-cols-1 md:grid-cols-2 gap-12 text-gray-600 text-base leading-relaxed animate-in fade-in duration-500">
                 <div>
                   <h3 className="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2"><Sparkles className="text-amber-500" size={24}/> Göz Kamaştıran Zarafet</h3>
                   <p className="mb-4">Tamamen el işçiliği ile üretilen bu özel tasarım kolye, günlük kullanımda zarafetinizi tamamlarken, özel günlerde de şıklığınızın en büyük destekçisi olacak. İçerisindeki zirkon taşlar pırlanta kesim tekniğiyle işlendiği için ekstra parlaklık sunar.</p>
                   <p>Ürün, markamıza ait özel kadife hediye kutusunda, garanti belgesi ve bakım bezi ile birlikte gönderilmektedir. Hediye notu eklemek isterseniz sipariş aşamasında belirtebilirsiniz.</p>
                 </div>
                 
                 <div className="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                   <h3 className="text-lg font-bold text-gray-900 mb-4">Teknik Detaylar</h3>
                   <ul className="space-y-4 divide-y divide-gray-50">
                      <li className="flex justify-between pt-2"><span className="text-gray-500">Materyal</span><span className="font-bold text-gray-900">925 Ayar Gümüş</span></li>
                      <li className="flex justify-between pt-4"><span className="text-gray-500">Taş Cinsi</span><span className="font-bold text-gray-900">A+ Kalite Zirkon</span></li>
                      <li className="flex justify-between pt-4"><span className="text-gray-500">Zincir Uzunluğu</span><span className="font-bold text-gray-900">45 cm + 5 cm Uzatma</span></li>
                      <li className="flex justify-between pt-4"><span className="text-gray-500">Kaplama</span><span className="font-bold text-gray-900">Rose Gold (Pembe Altın)</span></li>
                      <li className="flex justify-between pt-4 pb-2"><span className="text-gray-500">Garanti Süresi</span><span className="font-bold text-gray-900">2 Yıl</span></li>
                   </ul>
                 </div>
              </div>
            )}

            {/* 2. SEKM: DEĞERLENDİRMELER */}
            {activeTab === 'degerlendirmeler' && (
              <div className="grid grid-cols-1 lg:grid-cols-3 gap-12 animate-in fade-in duration-500">
                {/* Sol: Genel Puan Özeti */}
                <div className="bg-gray-50 rounded-3xl p-8 border border-gray-100 h-fit">
                  <div className="text-center mb-6">
                    <h3 className="text-5xl font-extrabold text-gray-900">4.8</h3>
                    <div className="flex justify-center text-amber-400 my-3">
                      <Star size={24} fill="currentColor" /><Star size={24} fill="currentColor" /><Star size={24} fill="currentColor" /><Star size={24} fill="currentColor" /><Star size={24} fill="currentColor" className="text-amber-400/30" />
                    </div>
                    <p className="text-gray-500 font-medium">128 Değerlendirme</p>
                  </div>
                  
                  <div className="space-y-3">
                    {[
                      { stars: 5, percent: 85, count: 109 },
                      { stars: 4, percent: 10, count: 12 },
                      { stars: 3, percent: 3, count: 4 },
                      { stars: 2, percent: 1, count: 2 },
                      { stars: 1, percent: 1, count: 1 },
                    ].map((row) => (
                      <div key={row.stars} className="flex items-center gap-3 text-sm">
                        <span className="font-medium text-gray-700 w-3">{row.stars}</span>
                        <Star size={14} className="text-amber-400" fill="currentColor" />
                        <div className="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                          <div className="h-full bg-amber-400 rounded-full" style={{ width: `${row.percent}%` }}></div>
                        </div>
                        <span className="text-gray-500 w-6 text-right">{row.count}</span>
                      </div>
                    ))}
                  </div>
                  <button className="w-full mt-8 bg-white border-2 border-gray-200 text-gray-800 font-bold py-3 rounded-xl hover:border-rose-600 hover:text-rose-600 transition">Değerlendirme Yaz</button>
                </div>

                {/* Sağ: Kullanıcı Yorumları Listesi */}
                <div className="lg:col-span-2 space-y-6">
                  {[
                    { id: 1, name: "Ayşe Y.", date: "12 Ekim 2025", text: "Gerçekten görseldekinden çok daha parlak ve zarif. Hediye paketi de inanılmaz özenliydi. Emeğinize sağlık.", verified: true, likes: 14 },
                    { id: 2, name: "Mehmet K.", date: "5 Ekim 2025", text: "Eşime evlilik yıldönümümüz için aldım, bayıldı. Kararma yapar mı diye korkmuştum ama haftalardır boynundan çıkarmıyor, ilk günkü gibi pırıl pırıl.", verified: true, likes: 8 },
                    { id: 3, name: "Selin T.", date: "28 Eylül 2025", text: "Kargo çok hızlıydı, ertesi gün elimdeydi. Zinciri biraz daha uzun olabilirdi ama uzatma aparatı hayat kurtarıyor.", verified: false, likes: 2 },
                  ].map((review) => (
                    <div key={review.id} className="border-b border-gray-100 pb-6 last:border-0">
                      <div className="flex justify-between items-start mb-3">
                        <div className="flex items-center gap-3">
                          <div className="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold">
                            {review.name.charAt(0)}
                          </div>
                          <div>
                            <p className="font-bold text-gray-900 flex items-center gap-2">
                              {review.name} 
                              {review.verified && <span className="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full flex items-center gap-1"><Check size={10} /> Onaylı Alıcı</span>}
                            </p>
                            <div className="flex items-center gap-2 text-xs text-gray-500 mt-1">
                              <div className="flex text-amber-400">
                                <Star size={12} fill="currentColor" /><Star size={12} fill="currentColor" /><Star size={12} fill="currentColor" /><Star size={12} fill="currentColor" /><Star size={12} fill="currentColor" />
                              </div>
                              <span>• {review.date}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <p className="text-gray-600 text-sm leading-relaxed mb-4">{review.text}</p>
                      <button className="text-xs font-medium text-gray-500 hover:text-rose-600 flex items-center gap-1 transition">
                        <ThumbsUp size={14} /> Faydalı Buldum ({review.likes})
                      </button>
                    </div>
                  ))}
                  <button className="text-rose-600 font-bold text-sm w-full text-center py-4 hover:bg-rose-50 rounded-xl transition">Tüm Değerlendirmeleri Gör (128)</button>
                </div>
              </div>
            )}

            {/* 3. SEKM: İADE VE DEĞİŞİM */}
            {activeTab === 'iade' && (
              <div className="animate-in fade-in duration-500">
                {/* 3 Adımda İade Kartları */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                  <div className="bg-white border border-gray-200 rounded-2xl p-6 text-center hover:border-rose-300 transition group">
                    <div className="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center text-rose-600 mx-auto mb-4 group-hover:scale-110 transition-transform">
                      <RefreshCw size={28} />
                    </div>
                    <h4 className="font-bold text-gray-900 mb-2">1. Talebini Oluştur</h4>
                    <p className="text-sm text-gray-500">Hesabım sayfasından siparişini seç ve 14 gün içinde iade talebini tek tıkla oluştur.</p>
                  </div>
                  <div className="bg-white border border-gray-200 rounded-2xl p-6 text-center hover:border-blue-300 transition group">
                    <div className="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mx-auto mb-4 group-hover:scale-110 transition-transform">
                      <Truck size={28} />
                    </div>
                    <h4 className="font-bold text-gray-900 mb-2">2. Ücretsiz Gönder</h4>
                    <p className="text-sm text-gray-500">Ekranda beliren kargo kodunu kullanarak anlaşmalı kargo firmalarımıza ücretsiz teslim et.</p>
                  </div>
                  <div className="bg-white border border-gray-200 rounded-2xl p-6 text-center hover:border-emerald-300 transition group">
                    <div className="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 mx-auto mb-4 group-hover:scale-110 transition-transform">
                      <CreditCard size={28} />
                    </div>
                    <h4 className="font-bold text-gray-900 mb-2">3. Para İadeni Al</h4>
                    <p className="text-sm text-gray-500">Ürün depomuza ulaştıktan ve incelendikten sonra 1-3 iş günü içinde iaden kartına yansır.</p>
                  </div>
                </div>

                {/* İade Şartları Listesi */}
                <div className="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                  <h3 className="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <AlertCircle className="text-rose-600" /> İade & Değişim Şartları
                  </h3>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                    <ul className="space-y-4">
                      <li className="flex items-start gap-3">
                        <Check size={18} className="text-emerald-500 flex-shrink-0 mt-0.5" />
                        <span>Siparişiniz size ulaştıktan sonraki <strong>14 gün içerisinde</strong> iade veya değişim hakkınızı kullanabilirsiniz.</span>
                      </li>
                      <li className="flex items-start gap-3">
                        <Check size={18} className="text-emerald-500 flex-shrink-0 mt-0.5" />
                        <span>İade edilecek ürünlerin <strong>kullanılmamış</strong>, etiketleri koparılmamış ve orijinal kutusunda/ambalajında olması gerekmektedir.</span>
                      </li>
                    </ul>
                    <ul className="space-y-4">
                      <li className="flex items-start gap-3">
                        <Check size={18} className="text-emerald-500 flex-shrink-0 mt-0.5" />
                        <span><strong>Dijital Hizmetler:</strong> Lisans kodları, tema kurulumları veya hazır paketler satın alındıktan ve teslim edildikten sonra (dijital ürün doğası gereği) iade edilemez.</span>
                      </li>
                      <li className="flex items-start gap-3">
                        <Check size={18} className="text-emerald-500 flex-shrink-0 mt-0.5" />
                        <span><strong>Kişisel Bakım Ürünleri:</strong> Diş fırçası, krem, losyon gibi hijyenik ürünlerin ambalajı veya koruma bandı açıldığı takdirde iadesi yasal olarak kabul edilmemektedir.</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            )}
          </div>

        </main>
      )}

      {/* FOOTER ALANI */}
      <footer className="bg-gray-900 text-gray-300 py-16 mt-12 border-t border-gray-800">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          
          {/* Üst Footer: Sütunlar */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12 border-b border-gray-800 pb-12">
            
            {/* 1. Sütun: Marka & Hakkımızda */}
            <div className="col-span-1 lg:col-span-1">
              <div className="flex items-center gap-2 mb-6">
                <div className="w-10 h-10 bg-rose-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-rose-900/50">
                  <Gift size={20} />
                </div>
                <span className="font-extrabold text-2xl tracking-tight text-white">
                  hediyeme<span className="text-rose-500">.com</span>
                </span>
              </div>
              <p className="text-sm text-gray-400 mb-6 leading-relaxed pr-4">
                Sevdiklerinize ve kendinize en özel hediyeler, profesyonel dijital çözümlerden günlük kişisel bakıma kadar aradığınız her şey tek bir adreste.
              </p>
              <div className="flex gap-3">
                <a href="#" className="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all hover:-translate-y-1"><Facebook size={18} /></a>
                <a href="#" className="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all hover:-translate-y-1"><Instagram size={18} /></a>
                <a href="#" className="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all hover:-translate-y-1"><Twitter size={18} /></a>
              </div>
            </div>

            {/* 2. Sütun: Hızlı Linkler */}
            <div>
              <h3 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Kategoriler</h3>
              <ul className="space-y-3 text-sm text-gray-400">
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Dijital Hizmetler</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Takı & Mücevher</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Kişisel Bakım</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Dini Ürünler</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Ev & Yaşam</a></li>
              </ul>
            </div>

            {/* 3. Sütun: Müşteri Hizmetleri */}
            <div>
              <h3 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Müşteri Hizmetleri</h3>
              <ul className="space-y-3 text-sm text-gray-400">
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Hakkımızda</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Sipariş Takibi</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> İade ve Değişim Şartları</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Sıkça Sorulan Sorular</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Gizlilik ve Çerez Politikası</a></li>
              </ul>
            </div>

            {/* 4. Sütun: İletişim & Bülten */}
            <div>
              <h3 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">İletişim & Bülten</h3>
              <ul className="space-y-4 text-sm text-gray-400 mb-6">
                <li className="flex items-start gap-3"><MapPin size={18} className="text-rose-500 flex-shrink-0 mt-0.5" /> <span>İstiklal Cad. No:123<br/>Sakarya, Türkiye</span></li>
                <li className="flex items-center gap-3"><Phone size={18} className="text-rose-500 flex-shrink-0" /> <span>+90 (850) 123 45 67</span></li>
                <li className="flex items-center gap-3"><Mail size={18} className="text-rose-500 flex-shrink-0" /> <span>destek@hediyeme.com</span></li>
              </ul>
              {/* Bülten Kayıt */}
              <form className="flex mt-4" onSubmit={(e) => e.preventDefault()}>
                <input 
                  type="email" 
                  placeholder="E-posta adresiniz" 
                  className="bg-gray-800 border border-gray-700 text-sm text-white px-4 py-2.5 rounded-l-lg focus:outline-none focus:border-rose-500 w-full" 
                />
                <button 
                  type="submit" 
                  className="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2.5 rounded-r-lg transition-colors font-medium text-sm whitespace-nowrap"
                >
                  Abone Ol
                </button>
              </form>
            </div>
          </div>

          {/* Alt Footer: Telif ve Ödeme Yöntemleri */}
          <div className="flex flex-col md:flex-row justify-between items-center gap-6">
            <div className="text-sm text-gray-500 text-center md:text-left">
              &copy; {new Date().getFullYear()} hediyeme.com. Tüm hakları saklıdır.
            </div>
            
            {/* Tasarımsal Ödeme İkonları */}
            <div className="flex gap-3 opacity-70">
              <div className="w-12 h-8 bg-white rounded flex items-center justify-center text-[11px] font-extrabold text-blue-900 italic">VISA</div>
              <div className="w-12 h-8 bg-white rounded flex items-center justify-center text-[11px] font-extrabold text-red-600">MASTER</div>
              <div className="w-12 h-8 bg-white rounded flex items-center justify-center text-[11px] font-extrabold text-cyan-700">AMEX</div>
              <div className="w-12 h-8 bg-gray-800 rounded flex items-center justify-center text-[11px] font-extrabold border border-gray-600 text-white">TROY</div>
            </div>
          </div>
          
        </div>
      </footer>

    </div>
  );
}