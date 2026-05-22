using IUTGame;
using MaimLandProject.IHM;
using MaimLandProject.Metier.Food;
using System.Text;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace MaimLandProject
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }
        public void Start_Game(object sender, RoutedEventArgs e)
        {
            Jeu fenetreJeu = new Jeu(); // crée une instance de la fenêtre du jeu
            fenetreJeu.Show();          // ouvre la fenêtre
            FoodItem.EatCount = 0;

        }

        private void Exite_Game(object sender, RoutedEventArgs e)
        {
            Application.Current.Shutdown();
        }

        private void Settings_Game(object sender, RoutedEventArgs e)
        {
            Window1 settingsWindow = new Window1(); // Or use SettingsWindow if renamed
            settingsWindow.ShowDialog(); // Opens settings and pauses MainWindow
        }
    }
}