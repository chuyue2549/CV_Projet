using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using IUTGame;
using IUTGame.WPF;
using MaimLandProject.Metier;
using MaimLandProject.Metier.Food;

namespace MaimLandProject.IHM
{
    /// <summary>
    /// Interaction logic for Jeu.xaml
    /// </summary>
    public partial class Jeu : Window
    {
        public Jeu()
        {
            InitializeComponent();
            Loaded += (s, e) =>
            {
                var screen = new WPFScreen(GameCanvas);
                var jeu = new LeJeu(screen, ScoreText);


                jeu.Run();

            };
        }

        private void Settings_Game(object sender, RoutedEventArgs e)
        {
            Window1 settingsWindow = new Window1();
            settingsWindow.ShowDialog();
        }
    }
}
