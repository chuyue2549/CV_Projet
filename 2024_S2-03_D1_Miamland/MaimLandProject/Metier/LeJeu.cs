using System.Diagnostics;
using System.Windows.Controls;
using IUTGame;
using MaimLandProject.Metier.Food;
using static System.Formats.Asn1.AsnWriter;

namespace MaimLandProject.Metier
{
    public class LeJeu : Game
    {
        #region attributs
        private FoodCreate foodManager;
        /// <summary>
        ///list de tous les objets présents dans le jeu (joueur, monstres, aliments)
        /// </summary>
        private List<GameItem> objets = new List<GameItem>();
        private int nbMonstre = 0;

        #endregion

        #region propriétés
        public List<GameItem> Objets { get { return objets; } set { objets = value; }}
        #endregion

        #region constructeur
        /// <summary>
        /// initial de jeu
        /// </summary>
        /// <param name="screen"> zone pour le jeu</param>
        /// <param name="scoretext"> zone de text pour le count</param>
        public LeJeu(IScreen screen, TextBlock scoretext) : base(screen, "Sprites", "Sound")
        {
            FoodItem.ScoreText = scoretext;
        }

        /// <summary>
        /// Le constructeur qui n'a pas TextBlock dans paramètre pour faciliter le teste unitaire
        /// </summary>
        /// <param name="screen">l'écran ou le jeu va être affiché</param>
        public LeJeu(IScreen screen):base (screen, "Sprites", "Sound")
        {

        }
        #endregion

        #region methodes
        /// <summary>
        ///Cette méthode permet d’ajouter un objet à la fois dans le jeu et dans la liste Objets, 
        /// </summary>
        /// <param name="item"> item qui va ajouter dans list et affichier sur l'ecran</param>
        public void AjouterObjetEtJeu(GameItem item)
        {
            objets.Add(item);
            AddItem(item);
        }

        
        /// <summary>
        /// initial tous les items 
        /// </summary>
        protected override void InitItems()
        {

            //song lancer
            
            SoundStore.Get("song.mp3").Volume = 0.5;
            PlayBackgroundMusic("song.mp3");

            double x = Screen.Width / 2;
            double y = Screen.Height / 2;
            //Crée le personnage
            Personnage j = new Personnage(x, y, this);
            //Ajoute au jeu
            AjouterObjetEtJeu(j);

            Monstre m1 = new Monstre(Screen.Width - 116, 10 , this);
            AjouterObjetEtJeu(m1);

            foodManager = new FoodCreate(this, 4);

        }

        /// <summary>
        /// Vérifie si on doit ajouter un monstre selon le nombre d’aliments mangés.
        /// </summary>
        public void ConfirmAddMonster()
        {

            int nbMaxMonster = FoodItem.EatCount / 3;

            while (nbMonstre < nbMaxMonster)
            {
                AddMonstreOrder();
                nbMonstre++;
            }

        }

        /// <summary>
        /// Ajoute un monstre à une position aléatoire.
        /// </summary>
        public void AddMonstreRamdom()
        {
            Random random = new Random();
            List<double> PositionY = new List<double>();
            PositionY.Add(180);

            double x = Screen.Width - 116;
            double y = random.Next(0, (int)this.Screen.Height - 116);

            do
            {
                y = random.Next(0, (int)this.Screen.Height - 116);
            }
            while (PositionY.Contains(y));

            PositionY.Add(y);


            Monstre ranMonstre = new Monstre(x, y, this);
            AjouterObjetEtJeu(ranMonstre);

        }

        /// <summary>
        /// Ajoute des monstres à des positions fixes selon le nombre manger.
        /// </summary>
        public void AddMonstreOrder()
        {

            if (FoodItem.EatCount == 3)
            {
                Monstre m2 = new Monstre(Screen.Width - 116, 350, this);
                AjouterObjetEtJeu(m2);

            }
            else if (FoodItem.EatCount == 6)
            {
                Monstre m3 = new Monstre(Screen.Width - 116, 150, this);
                AjouterObjetEtJeu(m3);

            }
            else if (FoodItem.EatCount == 9)
            {
                Monstre m4 = new Monstre(Screen.Width - 116, 480, this);
                AjouterObjetEtJeu(m4);

            }

        }

        /// <summary>
        /// Affiche en cas de victoire.
        /// </summary>
        protected override void RunWhenWin()
        {
            System.Windows.MessageBox.Show(Res.Strings.whenWin);
        }

        /// <summary>
        /// Affiche en cas de défaite.
        /// </summary>
        protected override void RunWhenLoose()
        {
            System.Windows.MessageBox.Show(Res.Strings.whenLoose);
        }
        #endregion
    }
}
